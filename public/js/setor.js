var setores;

function getSetores(){
    setores = sendToDataBase("../src/lib/main.php", [{'rt' : 'setor', 'op' : 'listarTabela'}]);

    if (setores == '[]'){
        setores = [{"setcodigo" : 0, "Descrição do Setor" : 'Nenhum Registro encontrado :(', "Situação" : ''}];
    }
    else{
        setores = JSON.parse(setores);
    }
}


function getDadosSetores(){
    getSetoresFiltro(setores, 'SetorSelect');
    getSetoresFiltro(setores, 'SetorDispSelect');
    montaTabela(setores, 'setorTable', 'SetorInfo');
}

function showTableSetoresFiltrados(filtro){
    let setoresFiltrados = getValuesByFiltro(filtro, setores, 1)

    document.getElementById('setorTable').innerHTML = '';

    if(setoresFiltrados.length == 0){
        setoresFiltrados = [{"setcodigo" : 0, "Descrição do Setor" : 'Não encontrado :(', "Situação" : ''}];
    }
    
    desativaButtonsToolbar('SetorInfo');
    montaTabela(setoresFiltrados, 'setorTable', 'SetorInfo');
}

async function addNewSetor(){
    let valid = validateSession();

    if (valid){
        let modal = createModal('Adicionar Novo Setor', 'Informe o Nome do Setor: ');  
        let modalContainer = document.getElementById('modalContainer');
        let confirmar = document.createElement('button');

        let input = document.createElement('input')
        input.setAttribute('type', 'text');
        input.id = 'ModalInput';

        modalContainer.appendChild(input)
        
        confirmar.classList.add('buttons');
        confirmar.classList.add('CenterButton');
        confirmar.innerText='Adicionar';
        confirmar.setAttribute('onclick', 'inserirSetor()');

        modalContainer.appendChild(confirmar);

        await sleep(200); 
        showModal(modal)
    }
}

function inserirSetor(){
    let setor = document.getElementById('ModalInput').value;
    if (setor.trim() != '') {
        sendToDataBase('../src/lib/main.php', [{"rt" : 'setor', "op" : 'inserir', "setdescricao" : setor}]);
        getSetores();
        atualizaTable(setores,'setorTable','SetorInfo');
        destroyModal();
    }
}

async function confirmaRemoverSetor(button){ 
    if (button.className == 'IconButton'){           
        let valid = validateSession();

        if (valid){
            createModal('Remover Setor', 'Deseja Realmente remover o setor selecionado?');

            let modalContainer = document.getElementById('modalContainer');

            let confirmar = document.createElement('button');
            confirmar.classList.add('buttons');
            confirmar.classList.add('CenterButton');
            confirmar.innerText='Remover Setor';
            confirmar.setAttribute('onclick', 'getSetorRemover()');

            modalContainer.appendChild(confirmar);

            await sleep(200);
            showModal(modal);
        }
    }
}

function getSetorRemover(){
    removeSetor(getIdSelecionado('setorTable'))
}

function removeSetor(setcodigo){
    let execute = sendToDataBase('../src/lib/main.php', [{"rt" : 'setor', "op" : 'remover', 'setcodigo' : setcodigo}]);

    if (!execute){
        let erro = createError('Erro ao Remover Setor', 'Este setor ja foi utilizado para responder avaliações, não é possivel removê-lo. Caso deseje, e possivel desativar o mesmo para não ser mais utilizado no sistema.');
        showModal(erro);
    }


    getSetores();
    atualizaTable(setores,'setorTable','SetorInfo');
    destroyModal();
}

function getSetorDesativar(button){   
    if (button.className == 'IconButton'){   
        let valid = validateSession();

        if (valid){
            desativaSetor(getIdSelecionado('setorTable'))
        }
    }
}

function desativaSetor(setcodigo){
    sendToDataBase('../src/lib/main.php', [{"rt" : 'setor', "op" : 'desativar', 'setcodigo' : setcodigo}]);
    getSetores();
    atualizaTable(setores ,'setorTable','SetorInfo');
}



async function EditSetor(button){
    if (button.className == 'IconButton'){     
        let valid = validateSession();

        if (valid){
            let setor = GetRegistroFromId(getIdSelecionado('setorTable'), setores);

            let modal = createModal('Alterar Setor', 'Informe o novo nome do setor ');  
            let modalContainer = document.getElementById('modalContainer');
            let confirmar = document.createElement('button');

            let input = document.createElement('input')
            input.setAttribute('type', 'text');
            input.id = 'ModalInput';
            input.value = Object.values(setor)[1];

            modalContainer.appendChild(input)
            
            confirmar.classList.add('buttons');
            confirmar.classList.add('CenterButton');
            confirmar.innerText='Editar';
            confirmar.setAttribute('onclick', 'ModifySetor('+Object.values(setor)[0]+')');

            modalContainer.appendChild(confirmar);

            await sleep(200); 
            showModal(modal)
        }
    }
}

function ModifySetor(id){
    let setor = document.getElementById('ModalInput').value;
    sendToDataBase('../src/lib/main.php', [{"rt" : 'setor', "op" : 'editar', "setcodigo" : id, "setdescricao" : setor}]);
    getSetores();
    atualizaTable(setores,'setorTable','SetorInfo');
    destroyModal();
}

function getSetoresFiltro(valores, table){
    for (let i = 0; i < valores.length; i++) {
        if (Object.values(valores[i])[2] == 'Ativo') {
            addListFilter(table,Object.values(valores[i])[1],Object.values(valores[i])[1])
        }
    }
}

function createSetorSelectTable(tableID){
    let setoresSelect = []
    for (let i = 0; i < setores.length; i++) {
        if (Object.values(setores[i])[2] == 'Ativo') {
            setoresSelect.push({"setcodigo" : Object.values(setores[i])[0], "Setor" : Object.values(setores[i])[1]});
        }
    }

    montaSelectTable(setoresSelect, tableID)
}


function createSetorRadioTable(tableID){
    let setoresSelect = []
    for (let i = 0; i < setores.length; i++) {
        if (Object.values(setores[i])[2] == 'Ativo') {
            setoresSelect.push({"setcodigo" : Object.values(setores[i])[0], "Setor" : Object.values(setores[i])[1]});
        }
    }

    montaRadioTable(setoresSelect, tableID)
}

getSetores();