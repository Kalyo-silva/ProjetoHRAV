var graph;
var graphOption = 1;
var selectedSetor;


function loadDashboard(){
    setResultData(1);
    createSectorScore(1);
    drawGraph(graphOption);
    createFeedback();
}

function setResultData(tipo){
    let dataset = sendToDataBase('../src/lib/main.php', [{'rt' : 'dashboard', 'op' : 'carregaRespostas', 'tipo' : tipo}]);
    document.getElementById('DadosResposta').innerHTML = dataset;
}

function createSectorScore(tipo){
     let dataset = sendToDataBase('../src/lib/main.php', [{'rt' : 'dashboard', 'op' : 'carregaNotasSetores', 'tipo' : tipo}]);
     document.getElementById('scores').innerHTML = dataset;
}

function createFeedback(setcodigo){
    let dataset = sendToDataBase('../src/lib/main.php', [{'rt' : 'dashboard', 'op' : 'carregaUltimoFeedback', 'setcodigo' : setcodigo}]); 
    document.getElementById('Feedbacks').innerHTML = dataset;
}

function selectMedia(button){
    let container = button.parentNode;
    let buttons = container.getElementsByTagName('h4');

    for (let i = 0; i < buttons.length; i++) {
        buttons[i].className = '';
    } 

    button.className = 'invSelected';
}

function setButton(button){
    let container = document.getElementById('GraphControls');

    let buttons = container.getElementsByTagName('h4');
    
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].className = 'option';
    } 
    
    button.className = 'option selected';
}

function drawGraph(tipo, button){
    if (button != undefined){
        setButton(button);
    }

    if (tipo == undefined){
        tipo = graphOption;
    }

    let dataset = JSON.parse(sendToDataBase('../src/lib/main.php', [{'rt' : 'dashboard', 'op' : 'carregaDadosGrafico', 'tipo' : tipo, 'setcodigo' : selectedSetor}])); 

    graphOption = tipo;

    let datas = []
    let qtds = []

    for (let i = 0; i < dataset.length; i++) {
        datas.push(dataset[i].data);
        qtds.push(dataset[i].avaliacoes);        
    }

    let canvas = document.getElementById('grafRespostas');
    let style = getComputedStyle(document.body)

    if (graph != undefined){
        graph.destroy();
    }

    let label = ''

    switch (tipo) {
        case 1:
            label = 'Dias';
            break;
        case 2:
            label = 'Semanas';
            break;
        case 3:
            label = 'Meses';
            break;
        case 4:
            label = 'Meses';
            break;
        default:
            break;
    }

    graph = new Chart(canvas, {
        type: "line",
        data: {
            labels: datas,
            datasets: [{
                fill: true,
                lineTension: 0.3,
                backgroundColor: style.getPropertyValue('--bgcolor'),
                borderColor: style.getPropertyValue('--dtcolor'),
                data: qtds}]
        },
        options: {
            scales: {
              xAxes: [{scaleLabel: {display: true,
                                    labelString: label,
                                    fontColor : style.getPropertyValue('--dtcolor')
                                   }
              }],
              yAxes: [{ticks: {min: 0},
                       scaleLabel: {display: true,
                                    labelString: 'Respostas',
                                    fontColor : style.getPropertyValue('--dtcolor')
                                   }
                      }]
            },
            legend: {display: false},
        }
    });
}

function selectSetor(setor, id){
    let container = setor.parentNode;

    let setores = container.getElementsByTagName('div');

    if (selectedSetor == id){
        for (let i = 0; i < setores.length; i++) {
            setores[i].className = 'sectorIcon';
        } 

        createFeedback();
        
        selectedSetor = '';
    }
    else{
        for (let i = 0; i < setores.length; i++) {
            setores[i].className = 'sectorIcon inactivesectorIcon';
        }
        
        createFeedback(id);

        setor.className = 'sectorIcon';
        selectedSetor = id;
    }
}

function createGraficoHistorico(params){
    let dataset = JSON.parse(sendToDataBase('../src/lib/main.php', [params])); 
    let grafNotaPeriodo = document.getElementById('grafNotaPeriodo');
    let style = getComputedStyle(document.body)

    let titles = ['1-6', '7-8', '9-10'];
    let values = [dataset[0].low, dataset[0].mid, dataset[0].high];

    new Chart(grafNotaPeriodo, {
        type: "bar",
        data: {
            labels: titles,
            datasets: [{
                fill: true,
                lineTension: 0.3,
                backgroundColor: ['red', '#f29b00', 'green'],
                data: values}]
        },
        options: {
            scales: {
              xAxes: [{scaleLabel: {display: true,
                                    labelString: 'Notas',
                                    fontColor : style.getPropertyValue('--dtcolor')
                                   }
              }],
              yAxes: [{ticks: {min: 0},
                       scaleLabel: {display: true,
                                    labelString: 'Respostas',
                                    fontColor : style.getPropertyValue('--dtcolor')
                                   }
                      }]
            },
            legend: {display: false},
        }
    });
}

function showHistFeedback(){
    let modal = createModal('Histórico'); 

    showModal(modal);

    let container = modal.firstChild;

    container.style = "width: 90%; height: 95%; overflow-y : Scroll; display : block;";

    let content = sendToDataBase('../src/lib/main.php', [{'rt' : 'historico', 'op' : 'Listar', 'setor' : ''}])

    container.innerHTML += content;

    createGraficoHistorico({'rt' : 'historico', 'op' : 'grafico', 'setor' : ''});
}

function showHistFiltrado(){
    let setor = document.getElementById('HistSetorSelect').value;
    let dataini = document.getElementById('dataini').value;
    let datafim = document.getElementById('datafim').value;

    let content = sendToDataBase('../src/lib/main.php', [{'rt' : 'historico', 'op' : 'ListarFiltrado', 'setor' : setor, 'dataini' : dataini, 'datafim' : datafim}])

    document.getElementById('HistTable').innerHTML = content;

    content = sendToDataBase('../src/lib/main.php', [{'rt' : 'historico', 'op' : 'ListarNotaFiltrado', 'setor' : setor, 'dataini' : dataini, 'datafim' : datafim}])

    document.getElementById('HistNotaContainer').innerHTML = content;

    document.getElementById('NotaPeriodo').innerHTML = '<canvas id = "grafNotaPeriodo"></canvas>';
    createGraficoHistorico({'rt' : 'historico', 'op' : 'grafico', 'setor' : setor, 'dataini' : dataini, 'datafim' : datafim});

}