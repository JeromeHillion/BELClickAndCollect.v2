/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../styles/admin/admin_listBooks.css';

//Supprime un livre grâce à son ID
async function deleteBook(event){
     event.preventDefault();
    const url =this.href;

const tbody =document.querySelector('tbody');
  
    axios.get(url).then(function (response) {
       console.log(response);

       const line = document.getElementById(response.data.id);
        tbody.removeChild(line);
    });


}

//On attend que le DOM se charge
document.addEventListener('DOMContentLoaded', () => {

const links =document.querySelectorAll('#btn_delete');

links.forEach(function (link) {
    link.addEventListener('click', deleteBook);

})



});
