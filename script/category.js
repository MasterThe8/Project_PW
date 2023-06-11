let addCategoryDialog = document.getElementById("addCategoryDialog");
addCategoryDialog.style.display = "none";

let editCategoryDialog = document.getElementById("editCategoryDialog");
editCategoryDialog.style.display = "none";

let deleteCategoryDialog = document.getElementById("deleteCategoryDialog");
deleteCategoryDialog.style.display = "none";

function addCategory(){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    addCategoryDialog.style.display = "block";
    document.body.style.overflow = "hidden";
}

function editCategory(code,name){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    editCategoryDialog.style.display = "block";
    editCategoryDialog.style.zIndex = "999";
    document.body.style.overflow = "hidden";

    document.getElementById("categoryCodeEdit").value = code;
    document.getElementById("categoryNameEdit").value = name;
}

function deleteCategory(code,name){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    deleteCategoryDialog.style.display = "block";
    deleteCategoryDialog.style.zIndex = "999";
    document.body.style.overflow = "hidden";

    document.getElementById("categoryCodeDelete").value = code;
    document.getElementById("categoryNameDelete").value = name;
}

function closeCategory(){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "none";
    addCategoryDialog.style.display = "none";
    editCategoryDialog.style.display = "none";
    deleteCategoryDialog.style.display = "none";
    document.body.style.overflow = "auto";
}

