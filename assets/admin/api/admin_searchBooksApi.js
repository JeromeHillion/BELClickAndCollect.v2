import '../../styles/admin/api/admin_searchBooksApi.css';

/*Fonction qui va aller rechercher les livres via google books*/
function getBookDataApi(event) {
    event.preventDefault();
    let value = document.getElementById('input-value').value
    const url = window.location.origin + '/admin/api/reqSearchBooksApi/' + value;
    console.log(url);
    document.querySelector('svg').style.display = 'block';
    axios.get(url).then(function (response) {
        fillTable(response.data.books)
    });
}

/*On affiche les livres dans un tableau*/
function fillTable(books) {
    let html = "";
    console.log(books);
    document.querySelector('.table').style.display = 'block';
    document.getElementById('cardSearch');
    if (books) {
        books.forEach(function (book) {
            html += "<tr><td>" +
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
                "<td> <a href='#'>Voir</a> <a href='/admin/addBook/" + book.googleBookId + "'>Ajouter</a></td>"


        });
    } else {
        html += "<p>Résultats non trouvées !</p>"

    }
    document.getElementById('tbody').innerHTML = html;

    document.querySelector('svg').style.display = 'none';

}


document.addEventListener('DOMContentLoaded', () => {

    const btn_search = document.getElementById('btn-search');

    btn_search.addEventListener('click', getBookDataApi);


});
