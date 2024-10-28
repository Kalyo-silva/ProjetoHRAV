var dispositivos;
var dispositivoSelected;
var Iddispositivo;

function getDispositivos(){
    dispositivos = getFromDataBase("../src/dispositivos/getDispSession.php");

    dispositivos = JSON.parse(dispositivos);
}


function drawDispositivo(title, containerID, dispositivoID){
    let container = document.getElementById(containerID);

    let div = document.createElement('div');
    div.className = 'IconButton';
    div.id = 'Dispositivo_'+dispositivoID;
    div.setAttribute('onclick', 'selectdispositivo(this, "'+containerID+'")');
    
    div.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M200-40q-33 0-56.5-23.5T120-120v-720q0-33 23.5-56.5T200-920h560q33 0 56.5 23.5T840-840v720q0 33-23.5 56.5T760-40H200Zm0-200v120h560v-120H200Zm200 80h160v-40H400v40ZM200-320h560v-400H200v400Zm0-480h560v-40H200v40Zm0 0v-40 40Zm0 560v120-120Z"/></svg>'
    h3 = document.createElement('h3')
    h3.innerText = title;   

    div.appendChild(h3);

    container.appendChild(div);
}


function selectdispositivo(dispositivo, containerID){
    let container = document.getElementById(containerID);
    let campos = container.getElementsByClassName('IconButton');

    for (let i = 0; i < campos.length; i++) {
        campos[i].className = 'IconButton';        
    }

    dispositivo.className = 'IconButton dispositivoSelected';

    let id = (dispositivo.id).replace('Dispositivo_', '');
    dispositivoSelected = GetRegistroFromId(id, dispositivos)

    getSetorDispositivo(dispositivoSelected);

}

function createDispositivoSession(containerID){
    for (let i = 0; i < dispositivos.length; i++) {
            drawDispositivo(dispositivos[i].disnome, containerID, dispositivos[i].discodigo); 
    }
}

function getSetorDispositivo(dispositivo){

    document.getElementById('DispoID').innerText = 'Setor: '+dispositivo.setdescricao;
}

async function startSession(){
    if (dispositivoSelected == undefined){
        let modal = createModal('Erro ao iniciar sessão', 'Por favor, selecione um dispositivo.');
        await sleep(200);
        showModal(modal);
    }
    else{
        document.cookie = "discodigo="+dispositivoSelected.discodigo+"; SameSite=None; Secure";
        document.cookie = "setcodigo="+dispositivoSelected.setcodigo+"; SameSite=None; Secure";
        document.cookie = "start="+document.getElementById('Start').checked+"; SameSite=None; Secure";

        console.log(document.cookie);
        window.location.href = "questionario.html";
    }
}

getDispositivos();