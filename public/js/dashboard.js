var graph;
var selectedSetor;


function loadDashboard(){
    setResultData(1);
    createSectorScore(1);
    drawGraph(1);
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
    let dataset = JSON.parse(sendToDataBase('../src/lib/main.php', [{'rt' : 'dashboard', 'op' : 'carregaDadosGrafico', 'tipo' : tipo, 'setcodigo' : selectedSetor}])); 

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

function showHistFeedback(){
    let modal = createModal('Histórico de Feedbacks'); 

    showModal(modal);

    let container = modal.firstChild;

    container.style = "width: 80%; height: 90%;";

    let content = sendToDataBase('../src/lib/main.php', [{'rt' : 'historico', 'op' : 'Listar', 'setor' : ''}])

    container.innerHTML += content;
}

function showHistFeedbackFiltrado(setor){
    let content = sendToDataBase('../src/lib/main.php', [{'rt' : 'historico', 'op' : 'ListarFiltrado', 'setor' : setor.value}])

    document.getElementById('HistTable').innerHTML = content;

}