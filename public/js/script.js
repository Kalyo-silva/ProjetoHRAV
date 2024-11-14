var inactive;
var runTimer;
var FormStart;
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
var timer;

async function startTimer(){
    runTimer = true;
    timer = 30;
    inactive = false;

    for (undefined; timer >= 0; timer--) {
        await sleep(1000);    
    }

    if (runTimer){
        inactive = true;
        ShowTimeout();
    }
};

async function resetTimer(){
    if (!runTimer){
        startTimer();
    }

    timer = 30;
    
    document.getElementById('Timer').style = "transition: none; width : 100%";
    await sleep(100);
    document.getElementById('Timer').style = "width : 0%";
}

async function ShowTimeout() {
   destroyModal();
   let modal = createModal('Você ainda está ai?', 'Aviso: sessão inativa, cancelando o formulário em 5...');
   let modalContainer = document.getElementById('modalContainer');

    document.getElementById('modalClose').style = 'display : none;';

    let confirmar = document.createElement('button');
    confirmar.classList.add('buttons');
    confirmar.classList.add('CenterButton');
    confirmar.innerText='Retomar';
    confirmar.onclick = function(){inactive = false};
    
    modalContainer.appendChild(confirmar);
    
    await sleep(1);
    
    showModal(modal);

    for (let i = 5; i >= 0; i--) {
        if(!inactive){
            break;
        }

        await sleep(100);
        document.getElementById('modalText').innerText = 'Aviso: sessão inatíva, cancelando o formulário em '+i+'...';
        await sleep(900);
    }

    if(!inactive){
        resetTimer();
    }
    else{
        showEnding();
    }

    destroyModal();
}

function loadFormData(){
    data = JSON.parse(sendToDataBase("../src/lib/main.php", [{'op' : 'getAll', 'rt' : 'questionario', 'setor' : getValueFromCookie('setcodigo')}]));   

    console.log(data);

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
    if (!FormStart){
        resetTimer();
    }

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

async function showModal(modal){
    if (modal.style.visibility == ''){
        modal.style.visibility = 'visible'
        modal.style.opacity = 1;
    }
}

function destroyModal(){    
    let modalDiv = document.getElementById('modal');

    if(modalDiv != undefined){
        modalDiv.remove();
    }
}

async function quit(){
    if (runTimer){
        resetTimer();
    }
    
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
    document.getElementById('Timer').style = "transition: none; width : 100%";
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
            resetTimer();
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

        if (!FormStart){
            resetTimer();
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

        resetTimer();

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
    FormStart = true;
    runTimer = false;
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
    
    await sleep(100);
    FormStart = false;
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
    sendToDataBase('../src/lib/main.php', [{'rt' : 'questionario', 
                                            'op' : 'insert',
                                            'data' : JSON.stringify(data),
                                            'setcodigo' : getValueFromCookie('setcodigo'),
                                            'discodigo' :  getValueFromCookie('discodigo')}]);
    
    destroyModal();
    showEnding();
}

async function showEnding(){
    runTimer = false;

    let banner = document.getElementById('banner');
    let content = document.getElementById('content');
    let bannerMsg = document.getElementById('BannerMsg');
    let bannerContent = document.getElementById('BannerContent');
    let bannerBtn = document.getElementById('BannerBtn');
    let Countdown = document.getElementById('Countdown');

    banner.style.opacity = 0;
    content.style.opacity = 0;

    await sleep(200);

    Countdown.style.display = 'inline-block';
    Countdown.style.width = '90%';
    bannerBtn.style.display = 'none';
    bannerContent.innerText = 'O Hospital Regional Alto Vale (HRAV) agradece sua resposta e ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços.'
    bannerMsg.innerText = 'Obrigado Pela sua Resposta!'

    banner.style.display = 'flex';
    content.style.display = 'none';

    await sleep(1);
    banner.style.opacity = 1;
    Countdown.style.width = '0%';
    await sleep(5000);

    if (getValueFromCookie('start') == 'true'){
        banner.style.opacity = 0;

        await sleep(200);
        Countdown.style.display = 'none';
        bannerBtn.style.display = 'inline-block';
        bannerMsg.innerText = 'Ei, tem um minutinho?'
        bannerContent.innerText = 'Gostaria de responder uma pesquisa de satisfação?'

        banner.style.opacity = 1;
        
    }
    else{
        clearForm();
        loadQuestions();
    }
}