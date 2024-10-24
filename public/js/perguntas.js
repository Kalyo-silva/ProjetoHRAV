var perguntas;

function getPerguntas(){
    perguntas = getFromDataBase("../src/perguntas/getPerguntas.php");

    if (perguntas == '[]'){
        perguntas = [{"percodigo" : 0, "Pergunta" : 'Nenhum Registro encontrado :(', "Situacao" : '', "Setores Cadastrados" : ''}];
    }
    else{
        perguntas = JSON.parse(perguntas);
    }
}


function getDadosPerguntas(){
    montaTabela(perguntas, 'PerguntasTable', 'PerguntaInfo');
}

function getPerguntaDesativar(button){
    if (button.className == 'IconButton'){
        let valid = validateSession();
        
        if (valid){
            desativaPergunta(getIdSelecionado('PerguntasTable'))
        }
    }
}

function desativaPergunta(percodigo){
    sendToDataBase('../src/perguntas/desativaPergunta.php', [{'percodigo' : percodigo}]);
    getPerguntas();
    atualizaTable(perguntas ,'PerguntasTable','PerguntaInfo');
}


async function confirmaRemoverPergunta(button){
    if (button.className == 'IconButton'){
        let valid = validateSession();

        if (valid){
            createModal('Remover Pergunta', 'Deseja Realmente remover a pergunta selecionada?');

            let modalContainer = document.getElementById('modalContainer');

            let confirmar = document.createElement('button');
            confirmar.classList.add('buttons');
            confirmar.classList.add('CenterButton');
            confirmar.innerText='Remover Pergunta';
            confirmar.setAttribute('onclick', 'getPerguntaRemover()');

            modalContainer.appendChild(confirmar);

            await sleep(200);
            showModal(modal);
        }
    }
}

function getPerguntaRemover(){
    removePergunta(getIdSelecionado('PerguntasTable'))
}

function removePergunta(percodigo){
    sendToDataBase('../src/perguntas/removePergunta.php', [{'percodigo' : percodigo}]);
    getPerguntas();
    atualizaTable(perguntas,'PerguntasTable','PerguntaInfo');
    destroyModal();
}


async function addNewPergunta(){
    let valid = validateSession();

    if (valid){
        let modal = createModal('Adicionar Nova Pergunta', '');  
        let modalContainer = document.getElementById('modalContainer');
        modalContainer.style = 'width : 50%'
        let wrapper = document.createElement('div');
        wrapper.id = 'TextBox';

        let contentContainer = document.createElement('div');
        contentContainer.id = 'ContentContainer';
        let selectContainer = document.createElement('div');
        selectContainer.id = 'selectContainer';
        let setorTable = document.createElement('table');
        setorTable.id = 'SelectSetorTable'
        let confirma = document.createElement('button');
        confirma.id = 'ModalInput'
        confirma.className = 'buttons CenterButton';
        confirma.innerText = 'Adicionar';
        confirma.setAttribute('onclick', 'inserirPergunta()');

        let h2 = document.createElement('h2');
        h2.innerText = 'Pergunta';

        let textarea = document.createElement('textarea');
        textarea.id = 'textPergunta';
        textarea.style = 'width: -webkit-fill-available; margin-right: 1rem; height: 5rem;';

        modalContainer.appendChild(contentContainer);
        contentContainer.appendChild(selectContainer);
        contentContainer.appendChild(wrapper);
        selectContainer.appendChild(setorTable);
        wrapper.appendChild(h2);
        wrapper.appendChild(textarea);
        modalContainer.append(confirma);

        createSetorSelectTable('SelectSetorTable');
        
        await sleep(200); 
        showModal(modal)
    }
}

function inserirPergunta(){
    let pergunta = document.getElementById('textPergunta').value;

    let setores = [];

    let tableSetores = document.getElementById('SelectSetorTable');
    let checks = tableSetores.getElementsByTagName('input');

    for (let i = 0; i < checks.length; i++) {
        if (checks[i].checked == true){
            setores.push(checks[i].value);
        }
    }

    sendToDataBase('../src/perguntas/addPergunta.php', [{'perdescricao' : pergunta, 'setcodigo' : setores}]);
    getPerguntas();
    atualizaTable(perguntas,'PerguntasTable','PerguntaInfo');
    destroyModal();
}

function filtraSetorPergunta(setor){
    let perguntasFiltradas;

    if (setor.value != 0){
        perguntasFiltradas= getValuesByFiltro(setor.value, perguntas, 3);
    }
    else{
        perguntasFiltradas = perguntas;
    }
    
    document.getElementById('PerguntasTable').innerHTML = '';

    if(perguntasFiltradas.length == 0){
        perguntasFiltradas = [{"percodigo" : 0, "Pergunta" : 'Nenhum registro encontrado :('}];
    }
    
    desativaButtonsToolbar('PerguntaInfo');
    montaTabela(perguntasFiltradas, 'PerguntasTable', 'PerguntaInfo');
}



function showTablePerguntasFiltrados(filtro){
    let perguntasFiltradas = getValuesByFiltro(filtro, perguntas, 1)

    document.getElementById('PerguntasTable').innerHTML = '';

    if(perguntasFiltradas.length == 0){
        perguntasFiltradas = [{"percodigo" : 0, "Pergunta" : 'Nenhum registro encontrado :('}];
    }
    
    desativaButtonsToolbar('PerguntaInfo');
    montaTabela(perguntasFiltradas, 'PerguntasTable', 'PerguntaInfo');
}

getPerguntas();
