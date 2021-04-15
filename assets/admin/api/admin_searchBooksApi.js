import '../../styles/admin/api/admin_searchBooksApi.css';

/*Fonction qui va aller rechercher les livres via google books*/
function getBookDataApi(event) {
    event.preventDefault();
    document.getElementById("notFound").style.display = 'none';
    let value = document.getElementById('input-value').value
    const url = window.location.origin + '/admin/api/reqSearchBooksApi/' + value;
    /*console.log(url);*/
    document.querySelector('svg').style.display = 'block';
    axios.get(url).then(function (response) {
        fillTable(response.data.books)
    });
}

/*On affiche les livres dans un tableau*/
function fillTable(books) {
    let html = "";
    console.log(books);

    if (books.length === 0) {
        document.getElementById("notFound").style.display = 'block';

    }

    document.querySelector('.table').style.display = 'block';
    document.getElementById('cardSearch');
    if (books) {
        books.forEach(function (book) {
            html +=
                "<tr><td>" +
                book.name +
                "</td>" +
                "<td>" +
                book.author +
                "</td>" +
                "<td>" +
                book.category +
                "</td>" +
                "<td>" +
                new Date(book.publication).toLocaleDateString() +
                "</td>" +
                "<td> <a href='/admin/addBook/" + book.googleBookId + "'>Ajouter</a></td></tr>"


        });
    }
    document.getElementById('tbody').innerHTML = html;

    document.querySelector('svg').style.display = 'none';

    const btn_add = document.querySelectorAll('tbody tr td a');
    /*console.log(btn_add)*/

    btn_add.forEach(function (btn) {
        btn.addEventListener('click', (event) => {
            event.preventDefault();
            const url = event.currentTarget.href;
            axios.get(url).then(function (response) {
                /*console.log(response.json());*/
                document.getElementById("success").style.display = 'block';
                setTimeout(msgSucces, 3000);

            }).catch((error) => {
                console.error(error);
                document.getElementById("error").style.display = 'block';
                setTimeout(msgError, 3000);
            })
        });

    })
}

function msgError() {
    document.getElementById("error").style.display = 'none';
}

function msgSucces() {
    document.getElementById("success").style.display = 'none';
}


//On attend que le DOM se charge
document.addEventListener('DOMContentLoaded', () => {

    const btn_search = document.getElementById('btn-search');
    btn_search.addEventListener('click', getBookDataApi);


});
