function atualizaTable(table, tableTagId, toolbar){
    montaTabela(table, tableTagId, toolbar);
    desativaButtonsToolbar(toolbar);
}

function getFromDataBase(request){
    let result = [];
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            result = xhttp.response;
        }
    };
    xhttp.open("POST", request, false);
    xhttp.send();   

    console.log(result);

    return result
}

function sendToDataBase(request, values){
    let params = '';

    for (let i = 0; i < Object.keys(values[0]).length; i++) {
        if (i == 0){
            params += Object.keys(values[0])[i] +'='+ Object.values(values[0])[i];
        } else{
            params += '&'+Object.keys(values[0])[i] +'='+ Object.values(values[0])[i];
        }
    }

    let result = [];
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            result = xhttp.response;
        }
    };
    xhttp.open("POST", request, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);   

    console.log(result);

    return result;
}


function getIdSelecionado(tableTagId){
    let table = document.getElementById(tableTagId);
    let radios = table.getElementsByTagName('input');

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked){
            return radios[i].value
        }        
    }    
}

function GetRegistroFromId(id, table){
    for (let i = 0; i < table.length; i++) {
        if (Object.values(table[i])[0] == id) {
            return table[i];
        }
    }
}

function montaTabela(tabela, tableTagId, toolbar){
    let table = document.getElementById(tableTagId);
    table.innerHTML = '';

    let tr = document.createElement('tr');
    table.appendChild(tr);
    
    for(i = 0; i < Object.keys(tabela[0]).length; i++){
        let th = document.createElement('th');

        if (i > 0){
            th.innerText = Object.keys(tabela[0])[i];
        }
        else
        {
            th.style = 'width : 15px';
        }
        tr.append(th);
    }

    for(i = 0; i < tabela.length; i++){
        let tr = document.createElement('tr');
        tr.id = tableTagId+'_'+Object.values(tabela[i])[0];
        table.appendChild(tr);

        for(j = 0; j < Object.values(tabela[i]).length; j++){

            let td = document.createElement('td');

            if (j == 0){
                let radio = document.createElement('input');
                radio.setAttribute('type','radio');
                radio.setAttribute('value', Object.values(tabela[i])[j]);
                radio.setAttribute('name', tableTagId+'_select');
                radio.value = Object.values(tabela[i])[0];
                radio.setAttribute('onclick', "selectRow('"+tableTagId+"_"+Object.values(tabela[i])[0]+"', '"+tableTagId+"', '"+toolbar+"')");
                tr.append(td);
                td.append(radio);
            }
            else{
                td.innerText = Object.values(tabela[i])[j];
                td.setAttribute('onclick', "selectRow('"+tableTagId+"_"+Object.values(tabela[i])[0]+"', '"+tableTagId+"', '"+toolbar+"')");
                tr.append(td);
            }
        }
    }
}

function montaSelectTable(dados, tableId){
    let table = document.getElementById(tableId);
    table.innerHTML = '';

    let tr = document.createElement('tr');
    table.appendChild(tr);
    
    for(i = 0; i < Object.keys(dados[0]).length; i++){
        let th = document.createElement('th');

        if (i > 0){
            th.innerText = Object.keys(dados[0])[i];
        }
        else
        {
            th.style = 'width : 15px';
        }
        tr.append(th);
    }  

    for(i = 0; i < dados.length; i++){
        let tr = document.createElement('tr');
        tr.id = tableId+'_'+Object.values(dados[i])[0];
        table.appendChild(tr);

        for(j = 0; j < Object.values(dados[i]).length; j++){

            let td = document.createElement('td');

            if (j == 0){
                let check = document.createElement('input');
                check.setAttribute('type','checkbox');
                check.setAttribute('value', Object.values(dados[i])[j]);
                check.setAttribute('name', 'select');
                check.value = Object.values(dados[i])[0];
                check.setAttribute('onclick','selectCheckRow("'+tableId+'_'+Object.values(dados[i])[0]+'")');
                td.setAttribute('onclick','selectCheckRow("'+tableId+'_'+Object.values(dados[i])[0]+'")');
                tr.append(td);
                td.append(check);
            }
            else{
                td.innerText = Object.values(dados[i])[j];
                td.setAttribute('onclick','selectCheckRow("'+tableId+'_'+Object.values(dados[i])[0]+'")');
                tr.append(td);
            }
        }
    }
}


function montaRadioTable(dados, tableId){
    let table = document.getElementById(tableId);
    table.innerHTML = '';

    let tr = document.createElement('tr');
    table.appendChild(tr);
    
    for(i = 0; i < Object.keys(dados[0]).length; i++){
        let th = document.createElement('th');

        if (i > 0){
            th.innerText = Object.keys(dados[0])[i];
        }
        else
        {
            th.style = 'width : 15px';
        }
        tr.append(th);
    }  

    for(i = 0; i < dados.length; i++){
        let tr = document.createElement('tr');
        tr.id = tableId+'_'+Object.values(dados[i])[0];
        table.appendChild(tr);

        for(j = 0; j < Object.values(dados[i]).length; j++){

            let td = document.createElement('td');

            if (j == 0){
                let check = document.createElement('input');
                check.setAttribute('type','radio');
                check.setAttribute('value', Object.values(dados[i])[j]);
                check.setAttribute('name', 'select');
                check.value = Object.values(dados[i])[0];
                check.setAttribute('onclick','selectRadioRow("'+tableId+'_'+Object.values(dados[i])[0]+'","'+tableId+'")');
                td.setAttribute('onclick','selectRadioRow("'+tableId+'_'+Object.values(dados[i])[0]+'","'+tableId+'")');
                tr.append(td);
                td.append(check);
            }
            else{
                td.innerText = Object.values(dados[i])[j];
                td.setAttribute('onclick','selectRadioRow("'+tableId+'_'+Object.values(dados[i])[0]+'","'+tableId+'")');
                tr.append(td);
            }
        }
    }
}


function AtivaButtonsToolbar(Ativo, toolbar){   
    let Toolbar = document.getElementById(toolbar);
    let Buttons = Toolbar.getElementsByClassName('IconButton');

    for (let i = 0; i < Buttons.length; i++) {
        Buttons[i].className = 'IconButton';  
    }

    if (Ativo == 1){
        Toolbar.getElementsByClassName('EnableText')[0].innerText = 'Desativar';      
    }
    else{
        Toolbar.getElementsByClassName('EnableText')[0].innerText = 'Ativar';
    }

}

function desativaButtonsToolbar(toolbar){
    let Toolbar = document.getElementById(toolbar);
    let Buttons = Toolbar.getElementsByClassName('IconButton');

    for (let i = 1; i < Buttons.length; i++) {
        Buttons[i].classList.add('deactivated_iconButton');
    }

    Toolbar.getElementsByClassName('EnableText')[0].innerText = 'Desativar';
}

function selectRow(row, tableTagId, toolbar){
    let table = document.getElementById(tableTagId);
    let rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        rows[i].classList = [];        
        let radio = rows[i].getElementsByTagName('input');
        radio[0].checked = false;
    }

    let linha = document.getElementById(row);
    radio = linha.getElementsByTagName('input');
    radio[0].checked = true;
    
    linha.className = 'trselected';

    let ativo = 1;

    if (linha.getElementsByTagName('td')[2].innerText == 'Desativado'){
        ativo = 0;
    }

    if (radio[0].value != 0){
        AtivaButtonsToolbar(ativo, toolbar);
    }
}

function selectCheckRow(row){
    let linha = document.getElementById(row);
    let check = linha.getElementsByTagName('input'); 
    
    if (check[0].checked == true){
        check[0].checked = false;
        linha.className = '';
    }     
    else{
        check[0].checked = true;
        linha.className = 'trselected';
    }
}


function selectRadioRow(row, tableTagId){
    let table = document.getElementById(tableTagId);
    let rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        rows[i].classList = [];        
        let radio = rows[i].getElementsByTagName('input');
        radio[0].checked = false;
    }

    let linha = document.getElementById(row);
    radio = linha.getElementsByTagName('input');
    radio[0].checked = true;
    
    linha.className = 'trselected';
}

function getValuesByFiltro(filtro, table, campoFiltrar){  
    let setoresFiltrados = [];

    for(i = 0; i < table.length; i++){ 
        if(Object.values(table[i])[campoFiltrar].toUpperCase().includes(filtro.toUpperCase())){
            setoresFiltrados.push(JSON.parse(JSON.stringify(table[i])));
        }
    }

    return setoresFiltrados;
}

function addListFilter(tableTagId, value, desc){
    table = document.getElementById(tableTagId);

    table.innerHTML += "<Option value = '"+value+"'>"+desc+"</option>";
}