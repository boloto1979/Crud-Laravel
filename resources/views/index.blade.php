<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD</title>
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;700&family=Roboto:wght@100;300;400;500;700;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      width: 100vw;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: rgba(0, 0, 0, 0.1);
    }

    button {
      cursor: pointer;
    }

    .container {
      width: 90%;
      height: 80%;
      border-radius: 10px;
      background: white;
    }

    .header {
      min-height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: auto 12px;
    }

    .header span {
      font-weight: 900;
      font-size: 20px;
      word-break: break-all;
    }

    #new {
      font-size: 16px;
      padding: 8px;
      border-radius: 5px;
      border: none;
      color: white;
      background-color: rgb(57, 57, 226);
    }

    .divTable {
      padding: 10px;
      width: auto;
      height: inherit;
      overflow: auto;
    }

    .divTable::-webkit-scrollbar {
      width: 12px;
      background-color: whitesmoke;
    }

    .divTable::-webkit-scrollbar-thumb {
      border-radius: 10px;
      background-color: darkgray;
    }

    table {
      width: 100%;
      border-spacing: 10px;
      word-break: break-all;
      border-collapse: collapse;
    }

    thead {
      background-color: whitesmoke;
    }

    tr {
      border-bottom: 1px solid rgb(238, 235, 235) !important;
    }

    tbody tr td {
      vertical-align: text-top;
      padding: 6px;
      max-width: 50px;
    }

    thead tr th {
      padding: 5px;
      text-align: start;
      margin-bottom: 50px;
    }

    tbody tr {
      margin-bottom: 50px;
    }

    thead tr th.acao {
      width: 100px !important;
      text-align: center;
    }

    tbody tr td.acao {
      text-align: center;
    }

    @media (max-width: 700px) {
      body {
        font-size: 10px;
      }

      .header span {
        font-size: 15px;
      }

      #new {
        padding: 5px;
        font-size: 10px;
      }

      thead tr th.acao {
        width: auto !important;
      }

      td button i {
        font-size: 20px !important;
      }

      td button i:first-child {
        margin-right: 0;
      }

      .modal {
        width: 90% !important;
      }

      .modal label {
        font-size: 12px !important;
      }
    }

    .modal-container {
      width: 100vw;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background-color: rgba(0, 0, 0, 0.5);
      display: none;
      z-index: 999;
      align-items: center;
      justify-content: center;
    }

    .modal {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px;
      background-color: white;
      border-radius: 10px;
      width: 50%;
    }

    .modal label {
      font-size: 14px;
      width: 100%;
    }

    .modal input {
      width: 100%;
      outline: none;
      padding: 5px 10px;
      width: 100%;
      margin-bottom: 20px;
      border-top: none;
      border-left: none;
      border-right: none;
    }

    .modal button {
      width: 100%;
      margin: 10px auto;
      outline: none;
      border-radius: 20px;
      padding: 5px 10px;
      width: 100%;
      border: none;
      background-color: rgb(57, 57, 226);
      color: white;
    }

    .active {
      display: flex;
    }

    .active .modal {
      animation: modal .4s;
    }

    @keyframes modal {
      from {
        opacity: 0;
        transform: translate3d(0, -60px, 0);
      }

      to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
      }
    }

    td button {
      border: none;
      outline: none;
      background: transparent;
    }

    td button i {
      font-size: 25px;
    }

    td button i:first-child {
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <span>Produto</span>
      <button onclick="openModal()" id="new">Incluir</i></button>
    </div>

    <div class="divTable">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th class="acao">Editar</th>
            <th class="acao">Excluir</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>

    <div class="modal-container">
      <div class="modal">
        <form action="/crud" method="POST">
          @csrf
          <label for="m-nome">Nome</label>
          <input id="m-nome" type="text" name="name"  required />

          <label for="m-numero">Descrição</label>
          <input id="m-numero" type="text" name="description"  required />

          <label for="m-local">Preço</label>
          <input id="m-local" type="number" name="price" onkeypress="(this,mreais)" required />
          <button id="btnSalvar">Salvar</button>
        </form>
      </div>
    </div>

  </div>
  <script>
    const modal = document.querySelector('.modal-container')
    const tbody = document.querySelector('tbody')
    const sNome = document.querySelector('#m-nome')
    const sNumero = document.querySelector('#m-numero')
    const sLocal = document.querySelector('#m-local')
    const btnSalvar = document.querySelector('#btnSalvar')

    let itens
    let id

    function openModal(edit = false, index = 0) {
      modal.classList.add('active')

      modal.onclick = e => {
        if (e.target.className.indexOf('modal-container') !== -1) {
          modal.classList.remove('active')
        }
      }

      if (edit) {
        sNome.value = itens[index].nome
        sNumero.value = itens[index].numero
        sLocal.value = itens[index].local
        id = index
      } else {
        sNome.value = ''
        sNumero.value = ''
        sLocal.value = ''
      }

    }

    function editItem(index) {

      openModal(true, index)
    }

    function deleteItem(index) {
      itens.splice(index, 1)
      setItensBD()
      loadItens()
    }

    function insertItem(item, index) {
      let tr = document.createElement('tr')

      tr.innerHTML = `
    <td>${item.nome}</td>
    <td>${item.numero}</td>
    <td>R$ ${item.local}</td>
    <td class="acao">
      <button onclick="editItem(${index})"><i class='bx bx-edit' ></i></button>
    </td>
    <td class="acao">
      <button onclick="deleteItem(${index})"><i class='bx bx-trash'></i></button>
    </td>
  `
      tbody.appendChild(tr)
    }

    btnSalvar.onclick = e => {

      if (sNome.value === '' || sNumero.value === '' || sLocal.value === '') {
        return
      }

      e.preventDefault();

      if (id !== undefined) {
        itens[id].nome = sNome.value
        itens[id].numero = sNumero.value
        itens[id].local = sLocal.value
      } else {
        itens.push({
          'nome': sNome.value,
          'numero': sNumero.value,
          'local': sLocal.value
        })
      }

      setItensBD()

      modal.classList.remove('active')
      loadItens()
      id = undefined
    }

    function loadItens() {
      itens = getItensBD()
      tbody.innerHTML = ''
      itens.forEach((item, index) => {
        insertItem(item, index)
      })

    }

    const getItensBD = () => JSON.parse(localStorage.getItem('dbfunc')) ?? []
    const setItensBD = () => localStorage.setItem('dbfunc', JSON.stringify(itens))

    loadItens()
  </script>
</body>

</html>
