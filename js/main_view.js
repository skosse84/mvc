let items = document.querySelectorAll(".dropdown-item");
let ActiveElem = getCookie("ActiveElem");
let desc = parseInt(getCookie("desc"));

if (desc) {
    sortButton.classList.remove("green");
    sortButton.classList.add("yellow");
    sortButton.classList.add("text_blue");
}

sortButton.addEventListener("click", (e) => {
    if (e.target.classList.contains("green")) {
        e.target.classList.remove("green");
        e.target.classList.add("yellow");
        e.target.classList.add("text_blue");
        e.target.classList.remove("text_white");
        document.cookie = "desc=1";
        location.reload();
    } else {
        e.target.classList.remove("yellow");
        e.target.classList.add("green");
        e.target.classList.add("text_white");
        e.target.classList.remove("text_blue");
        document.cookie = "desc=0";
        console.log(getCookie("desc"));
        location.reload();
    }
});

function clearActive() {
    items.forEach((val) => {
        val.classList.remove("active");
    })
}

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

if (ActiveElem != undefined) {
    clearActive();
    items.forEach((val) => {
        if (val.innerText == ActiveElem) {
            val.classList.add("active");
        }
    })
}

items.forEach((val) => {
    val.addEventListener("click", (e) => {
        clearActive();
        e.target.classList.add("active");
        document.cookie = "ActiveElem=" + e.target.innerText;
        location.reload();
    })
})