function getUser(id){
    if (id != ''){
        let user = sendToDataBase('../src/login/getUser.php',[{'usucodigo' : id}]);
        
        if (user != '[]'){
            user = JSON.parse(user);
            document.getElementById('usunome').innerText = user[0].usunome;
        }
        else{
            document.getElementById('usunome').innerText = '...';
        }
    }
    else{
        document.getElementById('usunome').innerText = '...';
    }
}

function validadeLogin(){
    let id = document.getElementById('usucodigo').value;
    let senha = document.getElementById('ususenha').value;
    senha = senha.trim();
    if (id != '' && senha != ''){
        let login = sendToDataBase('../src/login/validateLogin.php', [{'usucodigo' : id, 'ususenha' : senha}]);

        if (login != '[]'){
            sendToDataBase('../src/login/startSession.php', [{'usucodigo' : id}])
            window.location.href = 'admin.html';
        } 
        else{
            alert('Usuário ou senha incorretos!');
        }
    }
}

function showWarningNoLogin(){
    let modal = createModal('Sessão inválida', 'Por Favor, realize login para continuar');
    let modalContainer = document.getElementById('modalContainer');

    let confirmar = document.createElement('button');
    confirmar.classList.add('buttons');
    confirmar.classList.add('CenterButton');
    confirmar.innerText='Login';
    confirmar.onclick = function(){sendToLogin();};
    
    modalContainer.appendChild(confirmar);

    showModal(modal);
}

function sendToLogin(){
    window.location.href = "login.html";
}

function validateSession(){
    let valid = getFromDataBase('../src/login/getSessionStatus.php');

    if (!valid){
        showWarningNoLogin();
        return false
    }

    return true;
}