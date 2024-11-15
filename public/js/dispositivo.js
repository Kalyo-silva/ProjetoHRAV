var Dispositivos;

function getDispositivos(){
    Dispositivos = sendToDataBase("../src/lib/main.php", [{'rt' : 'dispositivos', 'op' : 'listarTabela'}]);

    if (Dispositivos == '[]'){
        Dispositivos = [{"discodigo" : 0, "Dispositivo" : 'Nenhum Registro encontrado :('}];
    }
    else{
        Dispositivos = JSON.parse(Dispositivos);
    }
}


function getDadosDispositivos(){
    montaTabela(Dispositivos, 'DispositivosTable', 'DispositivoInfo');
}

function getDispositivoDesativar(button){
    if (button.className == 'IconButton'){  
        let valid = validateSession();

        if (valid){
            desativaDispositivo(getIdSelecionado('DispositivosTable'))
        }
    }
}

function desativaDispositivo(discodigo){
    sendToDataBase('../src/lib/main.php', [{'rt' : 'dispositivos', 'op' : 'desativar', 'discodigo' : discodigo}]);
    getDispositivos();
    atualizaTable(Dispositivos ,'DispositivosTable','DispositivoInfo');
}


async function confirmaRemoverDispositivo(button){
    if (button.className == 'IconButton'){
        
        let valid = validateSession();

        if (valid){
            createModal('Remover Dispositivo', 'Deseja Realmente remover o dispositivo selecionado?');

            let modalContainer = document.getElementById('modalContainer');

            let confirmar = document.createElement('button');
            confirmar.classList.add('buttons');
            confirmar.classList.add('CenterButton');
            confirmar.innerText='Remover Dispositivo';
            confirmar.setAttribute('onclick', 'getDispositivoRemover()');

            modalContainer.appendChild(confirmar);

            await sleep(200);
            showModal(modal);
        }
    }
}

function getDispositivoRemover(){
    removeDispositivo(getIdSelecionado('DispositivosTable'))
}

function removeDispositivo(discodigo){
    let execute = sendToDataBase('../src/lib/main.php', [{'rt' : 'dispositivos', 'op' : 'remover','discodigo' : discodigo}]);
    
    if (!execute){
        let erro = createError('Erro ao Remover Dispositivo', 'Este dispositivo foi utilizado para cadastrar respostas no sistema de avaliações, não é possivel removê-lo. Caso queira, é possivel desativar este dispositivo para ele não ser disponibilizado no início da sessão.');
        showModal(erro);
    }

    getDispositivos();
    atualizaTable(Dispositivos,'DispositivosTable','DispositivoInfo');
    destroyModal();
}


async function addNewDispositivo(){
    let valid = validateSession();

    if (valid){
        let modal = createModal('Adicionar Novo Dispositivo', '');  
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
        confirma.setAttribute('onclick', 'inserirDispositivo()');

        let h2 = document.createElement('h2');
        h2.innerText = 'Dispositivo';

        let input = document.createElement('input');
        input.id = 'textDispositivo';
        input.setAttribute('type', 'text');
        input.style = 'font-size: 2rem; width: 85%;';

        modalContainer.appendChild(contentContainer);
        contentContainer.appendChild(selectContainer);
        contentContainer.appendChild(wrapper);
        selectContainer.appendChild(setorTable);
        wrapper.appendChild(h2);
        wrapper.appendChild(input);
        modalContainer.append(confirma);

        createSetorRadioTable('SelectSetorTable');
        
        await sleep(200); 
        showModal(modal)
    }
}

function inserirDispositivo(){
    let disnome = document.getElementById('textDispositivo').value;

    let setor;

    let tableSetores = document.getElementById('SelectSetorTable');
    let radio = tableSetores.getElementsByTagName('input');

    for (let i = 0; i < radio.length; i++) {
        if (radio[i].checked == true){
            setor = radio[i].value;
            break;
        }
    }

    sendToDataBase('../src/lib/main.php', [{'rt' : 'dispositivos', 'op' : 'inserir','disnome' : disnome, 'setcodigo' : setor}]);
    getDispositivos();
    atualizaTable(Dispositivos,'DispositivosTable','DispositivoInfo');
    destroyModal();
}

function filtraSetorDispositivo(setor){
    let DispositivosFiltrados;

    if (setor.value != 0){
        DispositivosFiltrados= getValuesByFiltro(setor.value, Dispositivos, 3);
    }
    else{
        DispositivosFiltrados = Dispositivos;
    }
    
    document.getElementById('DispositivosTable').innerHTML = '';

    if(DispositivosFiltrados.length == 0){
        DispositivosFiltrados = [{"discodigo" : 0, "Dispositivo" : 'Nenhum registro encontrado :('}];
    }
    
    desativaButtonsToolbar('DispositivoInfo');
    montaTabela(DispositivosFiltrados, 'DispositivosTable', 'DispositivoInfo');
}

async function editDispositivo(button){
    if (button.className == 'IconButton'){
        let valid = validateSession();

        if (valid){
            let dispositivo = GetRegistroFromId(getIdSelecionado('DispositivosTable'), Dispositivos);

            let modal = createModal('Alterar Dispositivo', 'Informe o novo nome do dispositivo ');  
            let modalContainer = document.getElementById('modalContainer');
            let confirmar = document.createElement('button');

            let input = document.createElement('input')
            input.setAttribute('type', 'text');
            input.id = 'ModalInput';
            input.value = Object.values(dispositivo)[1];

            modalContainer.appendChild(input)
            
            confirmar.classList.add('buttons');
            confirmar.classList.add('CenterButton');
            confirmar.innerText='Editar';
            confirmar.setAttribute('onclick', 'ModifyDispositivo('+Object.values(dispositivo)[0]+')');

            modalContainer.appendChild(confirmar);

            await sleep(200); 
            showModal(modal)
        }
    }
}

function ModifyDispositivo(id){
    let disnome = document.getElementById('ModalInput').value;
    sendToDataBase('../src/lib/main.php', [{'rt' : 'dispositivos', 'op' : 'editar', "discodigo" : id, "disnome" : disnome}]);
    getDispositivos();
    atualizaTable(Dispositivos,'DispositivosTable','DispositivoInfo');
    destroyModal();
}


getDispositivos();
