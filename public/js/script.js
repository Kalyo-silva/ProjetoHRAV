var cookies = document.cookie.split(';');

function getValueFromCookie(cookieName){
    for (let i = 0; i < cookies.length; i++) {
        let curCookie = cookies[i].split('=');

        if (curCookie[0].trim() == cookieName){
            return curCookie[1];
        }
    }
}

var data;

function loadFormData(){
    data = JSON.parse(sendToDataBase("../src/Questionario/getFormData.php", [{'setor' : getValueFromCookie('setcodigo')}]));   

    if (getValueFromCookie('start') == 'false'){
        loadQuestions();
    }
}

var atual = -1;

var root = document.getElementById('counterContainer');

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function createCounter(){

    for (let index = 0; index <= 10; index++) {
        let counter = document.createElement('button');
        counter.innerText = index;
        counter.classList.add('counter')
        counter.onclick = function(){getCounterValue(index)};

        root.appendChild(counter);           
    };
}

function getCounterValue(value){        
    let counters = root.getElementsByTagName('button');

    for (let index = 0; index <= 10; index++) {
        counters[index].className = 'counter';
        
        if(counters[index].innerText <= value){
            counters[index].classList.add('activeCounter');
        }
    }
    showFeedback();

    data[atual].nota = value;
};

function showFeedback() {
    let feed = document.getElementById('feedback');

    if (feed.style.visibility == '' || feed.style.visibility == 'hidden'){
        feed.style.visibility = 'visible'
        feed.style.opacity = 1;
    }
}

async function hideFeedback() {
    let feed = document.getElementById('feedback');

    if (feed.style.visibility == 'visible'){
        feed.style.opacity = 0;
        await sleep(1);
        feed.style.visibility = 'hidden'
    }
}


function saveFeedback(){
    let feed = document.getElementById('complemento');

    data[atual].feedback = feed.value;
    feed.value = '';
}

function loadFeedback(){
    let feed = document.getElementById('complemento');

    feed.value = data[atual].feedback;
}

function createModal(TitleMsg, TextMsg){
    let modalDiv = document.createElement('div');
    let modalContainer = document.createElement('div');
    let header = document.createElement('header');
    let title = document.createElement('h3');
    let close = document.createElement('h3');

    title.innerText = TitleMsg
    close.innerText = 'X'

    modalDiv.id = 'modal';
    modalContainer.id = 'modalContainer';
    header.id = 'modalHeader';
    title.id = 'modalTitle';
    close.id = 'modalClose';


    close.onclick = function(){destroyModal()}

    document.body.appendChild(modalDiv);
    modalDiv.appendChild(modalContainer);
    modalContainer.appendChild(header);
    header.appendChild(title);
    header.appendChild(close);

        
    if (TextMsg != ''){
        let text = document.createElement('h2');
        text.id = 'modalText';
        text.innerText = TextMsg;   
        modalContainer.appendChild(text); 
    }   

    return modalDiv;
}

function createError(errorTitle, ErrorMessage){
    let modal = createModal(errorTitle, ErrorMessage);
    modal.className = 'ErrorModal';
    modal.firstChild.className = 'ErrorContainer'

    let confirmar = document.createElement('button');
    confirmar.classList.add('buttons');
    confirmar.classList.add('CenterButton');
    confirmar.innerText='Voltar';
    confirmar.setAttribute('onclick', 'destroyModal()');

    modal.firstChild.appendChild(confirmar);
    
    return modal;
}

async function showModal(modal){
    if (modal.style.visibility == ''){
        modal.style.visibility = 'visible'
        modal.style.opacity = 1;
    }
}

function destroyModal(){    
    let modalDiv = document.getElementById('modal');

    modalDiv.remove();
}

async function quit(){
    let modal = createModal('Cancelar Formulário?', 'Tem certeza que deseja limpar a pesquisa de satisfação?');
    let modalContainer = document.getElementById('modalContainer');

    let confirmar = document.createElement('button');
    confirmar.classList.add('buttons');
    confirmar.classList.add('CenterButton');
    confirmar.innerText='Desejo Sair';
    confirmar.onclick = function(){destroyModal(); showEnding();};
    
    modalContainer.appendChild(confirmar);

    await sleep(1);
    showModal(modal);
}

function clearForm(){
    var feed = document.getElementById('complemento');
    
    for (let index = 0; index < Object.keys(data).length; index++) {
        data[index].nota = -1;
        data[index].feedback = '';        
    }
    atual = -1;
    document.getElementById('ant').classList.add('disabled');
    document.getElementById('prox').innerText = 'Próximo';
    feed.value = '';
}

function proximaQuestao(button){
    if (atual < Object.keys(data).length-1){
        if (atual >= 0){
            saveFeedback();
            document.getElementById('ant').className = 'buttons'; 
        }     

        atual += 1;

        showQuestao(data[atual].perpergunta);
        getCounterValue(data[atual].nota);

        if (data[atual].nota != -1){
            loadFeedback();
            showFeedback();
        } else{
            hideFeedback();
        }

        if (atual == Object.keys(data).length-1){
            button.innerText = 'Enviar'
        }
    } else{
        saveFeedback();
        validaRespostas();
    }
}

function questaoAnterior(button){
    if (atual > 0) {

        if (atual == Object.keys(data).length-1){
            document.getElementById('prox').innerText = 'Próximo'
        }

        saveFeedback();

        atual -= 1;
    
        showQuestao(data[atual].perpergunta);
        getCounterValue(data[atual].nota);

        if (data[atual].nota != -1){
            loadFeedback();
            showFeedback();
        } else{
            hideFeedback();
        }      

        if (atual == 0){
            button.classList.add('disabled');
        }
    }
}

function showQuestao(pergunta){
    let campoQuestao = document.getElementById('question');

    campoQuestao.innerText = (atual+1)+'. '+pergunta;
}


async function loadQuestions(){
    let banner = document.getElementById('banner');
    let content = document.getElementById('content');

    banner.style.opacity = 0;
    content.style.opacity = 0;

    await sleep(200);

    banner.style.display = 'none';
    content.style.display = 'flex';

    content.style.opacity = 1;

    clearForm();
    proximaQuestao();
}

async function showInvalidFormModal(){
    let modal = createModal('Formulário incompleto', 'Uma ou mais questões não foram respondidas, por favor, revise suas respostas.');
    let modalContainer = document.getElementById('modalContainer');

    let confirmar = document.createElement('button');
    confirmar.classList.add('buttons');
    confirmar.classList.add('CenterButton');
    confirmar.innerText='Voltar';
    confirmar.onclick = function(){destroyModal()};

    modalContainer.appendChild(confirmar);

    await sleep(1);
    showModal(modal);
}

async function ShowConfirmResposta(){
    let modal = createModal('Concluir', 'Deseja concluir a pesquisa?');
    let modalContainer = document.getElementById('modalContainer');

    let confirmar = document.createElement('button');
    confirmar.classList.add('buttons');
    confirmar.classList.add('CenterButton');
    confirmar.innerText='Concluir';
    confirmar.onclick = function(){EnviarDados()};

    modalContainer.appendChild(confirmar);

    await sleep(1);
    showModal(modal);
}

function validaRespostas(){
    let valid = true;
    let minIndex = -1;
    for (let index = 0; index < Object.keys(data).length; index++) {
        if (data[index].nota == -1){
            valid = false;
            minIndex = index+1;

            break;
        }
    }

    if (!valid){
        atual = minIndex;
        showInvalidFormModal();
        questaoAnterior(document.getElementById('ant'));
    } else {
        ShowConfirmResposta();
    }
}

function EnviarDados(){
    let avacodigo = JSON.parse(getFromDataBase('../src/Questionario/getNextAvacodigo.php'));
    avacodigo = Object.values(avacodigo[0])[0];

    for (let i = 0; i < data.length; i++) {
        sendToDataBase('../src/Questionario/SendFormResults.php',
        [{"avacodigo" : avacodigo,
          "percodigo" : data[i].percodigo,
          "setcodigo" : getValueFromCookie('setcodigo'),
          "discodigo" : getValueFromCookie('discodigo'),
          "avaresposta" : data[i].nota,
          "avafeedback" : data[i].feedback}]
        )
    }

    destroyModal();
    showEnding();
}

async function showEnding(){
    let banner = document.getElementById('banner');
    let content = document.getElementById('content');
    let bannerMsg = document.getElementById('BannerMsg');
    let bannerContent = document.getElementById('BannerContent');
    let bannerBtn = document.getElementById('BannerBtn');

    banner.style.opacity = 0;
    content.style.opacity = 0;

    await sleep(200);

    bannerBtn.style.visibility = 'hidden';
    bannerContent.innerText = 'O Hospital Regional Alto Vale (HRAV) agradece sua resposta e ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços.'
    bannerMsg.innerText = 'Obrigado Pela sua Resposta!'

    banner.style.display = 'flex';
    content.style.display = 'none';

    banner.style.opacity = 1;

    await sleep(5000);

    if (getValueFromCookie('start') == 'true'){
        banner.style.opacity = 0;

        await sleep(200);

        bannerBtn.style.visibility = 'visible';
        bannerMsg.innerText = 'Ei, tem um minutinho?'
        bannerContent.innerText = 'Gostaria de responder uma pesquisa de satisfação?'

        banner.style.opacity = 1;

    }
    else{
        clearForm();
        loadQuestions();
    }
}
