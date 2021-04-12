/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../../styles/admin/api/admin_searchBooksApi.css';

/*Fonction qui va aller rechercher les livres via google books*/
function getBookDataApi(event){
    event.preventDefault();
    let value= document.getElementById('input-value').value
    const url =window.location.origin + '/admin/api/reqSearchBooksApi/'+value;
console.log(url);
    axios.get(url).then(function (response){
       console.log(response)
    });
}

function fillTable(books) {
    let html = "";
    console.log(books);
    document.getElementById('cardSearch')
    for (let line of books.items) {
        html += "<tr><td class='col'>" +
            line.volumeInfo.title +
            "</td><td class='col'>" +
            line.volumeInfo.authors + "</td>" +
            "<td class='col-2'>" + line.volumeInfo.categories + "</td>"
            + "</td>" + "<td class='col-2'>" + line.volumeInfo.publishedDate + "</td>" +
            "<td class='col-2'><a href='/admin/getBook/" + line.id + "'" + "" + " class='btn btn-secondary me-2 btn-sm'>Voir</a><a href='#' class='btn btn-info text-light btn-sm'>Ajouter</a></td></tr>"

    }
        document.getElementById('tbody').innerHTML = html;



/*    if (html) {
        document.getElementById('tableData').classList.remove('d-none');
    }*/

}


document.addEventListener('DOMContentLoaded', () => {

   const btn_search= document.getElementById('btn-search');

   btn_search.addEventListener('click', getBookDataApi)


});
