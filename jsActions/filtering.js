function toggleContent(element) {
    const content = element.parentElement.querySelector('.content');
    const arrow = element.querySelector('.toggle');

    if (content.style.display === "flex" || content.style.display === "") {
        content.style.display = "none";
        arrow.classList.add("closed");
    } else {
        content.style.display = "flex";
        arrow.classList.remove("closed");
    }
}

function addQueryParam(key, value) {
    var currentURL = window.location.href;
    var url = new URL(currentURL);
    var searchParams = url.searchParams;

    if (searchParams.has(key)) {
        if (value !== "clear") searchParams.set(key, value);
        else searchParams.delete(key)
    } else if (value !== "clear") {
        searchParams.append(key, value);
    }

    var updatedURL = url.toString();

    window.location.href = updatedURL;
}

function fromProductToFiltering(key, value, type) {
    var currentURL = window.location.href;
    var url = new URL(currentURL);
    var searchParams = url.searchParams;

    searchParams.delete("productName");
    searchParams.append(key, value);

    let page;
    switch (type) {
        case "buty":
            page = 'shoes.php?';
            break;
        case "ubrania":
            page = 'clothes.php?'
            break;
    }

    var updatedURL = page + url.searchParams.toString();

    window.location.href = updatedURL;
}
