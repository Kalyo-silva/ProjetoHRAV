var graph;

function loadDashboard(){
    setResultData();
    createSectorScore();
    drawGraph(1);
    createFeedback();
}

function setResultData(){
    let dataset = JSON.parse(getFromDataBase('../src/dashboard/getDadosRespostas.php'));

    document.getElementById('avHj').innerText = Object.values(dataset[0])[0];
    document.getElementById('AvNum').innerText = Object.values(dataset[0])[1];
    document.getElementById('mdGeral').innerText = Object.values(dataset[0])[2];
}

function createSectorScore(){
    let dataset = JSON.parse(getFromDataBase('../src/dashboard/getDadosNotasSetores.php'));

    for (let i = 0; i < Object.keys(dataset).length; i++) {
            drawValues(Object.values(dataset[i])[0], Object.values(dataset[i])[1]); 
    }
}


function drawValues(item, value){
    let container = document.getElementById('scores');

    let div = document.createElement('div');
    let h3 = document.createElement('h3');
    let h2 = document.createElement('h2');

    div.className = 'sectorIcon';
    h3.innerText = item;
    h2.innerText = value;

    container.appendChild(div);
    div.appendChild(h3);
    div.appendChild(h2);
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
    let dataset = JSON.parse(sendToDataBase('../src/dashboard/getDataGraph.php', [{"tipo" : tipo}]));

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

function createFeedback(){
    let dataset = JSON.parse(getFromDataBase('../src/dashboard/getDataLastFeedback.php')); 

    let container = document.getElementById('LastFeedContainer');

    for(let i = 0; i < dataset.length; i++){
        let div = document.createElement('div');
        let h2 = document.createElement('h2');
        let h3 = document.createElement('h3');
        let h4 = document.createElement('h4');
        
        div.className = 'feedback';
        h2.className = 'feedbackTitle';

        h2.innerText = dataset[i].perpergunta;
        h3.innerText = dataset[i].avafeedback;
        h4.innerText = dataset[i].avadatahora+' - '+dataset[i].setdescricao;

        container.appendChild(div);
        div.appendChild(h2);
        div.appendChild(h3);
        div.appendChild(h4);
    }
}
