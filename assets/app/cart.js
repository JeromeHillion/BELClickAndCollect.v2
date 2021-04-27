/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../styles/app/cart.css';

//function qui ajoute un livre dans le panier grace à son id
async function addBookFromCart(event){
event.preventDefault();
const url = this.href;

axios.get(url).then(function (response){
    console.log(response);

});
}

//function qui supprime un livre dans le panier grace à son id
async function deleteBookFromCart(event){
    event.preventDefault();
    const url = this.href;
    console.log(url)
    const tbody = document.querySelector('tbody');
    axios.get(url).then(function (response){

        let line = document.getElementById("book_"+response.data.id);
        console.log(response.data);
        tbody.removeChild(line);
    
});
    
}

//function qui modifie la quantité de chaque livre
async function addQantity(event){
    event.preventDefault();
    const url = this.href;
    axios.get(url).then(function (response){
        const data = response.data.cart;        
    console.log(data.quantity);
});
    
}


document.addEventListener('DOMContentLoaded', ()=>{

if(document.querySelectorAll('#btn_add')){
    const addLinks = document.querySelectorAll('#btn_add');
    addLinks.forEach(function(addLink){
        addLink.addEventListener('click', addBookFromCart)
});

}
const deleteLinks = document.querySelectorAll('#btn_delete');
deleteLinks.forEach(function(deleteLink){
    deleteLink.addEventListener('click', deleteBookFromCart)
});


const add_quantity_links = document.querySelectorAll('#btn_add_quantity');
add_quantity_links.forEach(function(add_quantity_link){
    add_quantity_link.addEventListener('click', addQantity)
});
});
