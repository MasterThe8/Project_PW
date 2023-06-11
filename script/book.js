let addBookDialog = document.getElementById("addBookDialog");
addBookDialog.style.display = "none";

let editBookDialog = document.getElementById("editBookDialog");
editBookDialog.style.display = "none";

let deleteBookDialog = document.getElementById("deleteBookDialog");
deleteBookDialog.style.display = "none";

function addBook(){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    addBookDialog.style.display = "block";
    document.body.style.overflow = "hidden";
}

function editBook(code, title, year, price, category, publisher, writer, stock){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    editBookDialog.style.display = "block";
    editBookDialog.style.zIndex  = "999";
    document.body.style.overflow = "hidden";

    document.getElementById("bookCodeEdit").value = code;
    document.getElementById("bookNameEdit").value = title;
    document.getElementById("bookYearEdit").value = year;
    document.getElementById("bookPriceEdit").value = price;
    document.getElementById("bookPublisherEdit").value = publisher;
    document.getElementById("bookWriterEdit").value = writer;
    document.getElementById("bookStockEdit").value = stock;

    let bookCategory = document.getElementById("bookCategoryEdit");
    let optionElements = bookCategory.options;
    for (let i = 0; i < optionElements.length; i++){
        let option = optionElements[i];
        if (option.value === category){
            option.selected = true;
            break;
        }
    }
}

function deleteBook(code, title, year, category, publisher, writer, stock){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    deleteBookDialog.style.display = "block";
    deleteBookDialog.style.zIndex  = "999";
    document.body.style.overflow = "hidden";

    document.getElementById("bookCodeDelete").value = code;
    document.getElementById("bookNameDelete").value = title;
    document.getElementById("bookYearDelete").value = year;
    document.getElementById("bookCategoryDelete").value = category;
    document.getElementById("bookPublisherDelete").value = publisher;
    document.getElementById("bookWriterDelete").value = writer;
    document.getElementById("bookStockDelete").value = stock;
}

function closeBook(){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "none";
    addBookDialog.style.display = "none";
    editBookDialog.style.display = "none";
    deleteBookDialog.style.display = "none";
    document.body.style.overflow = "auto";
}