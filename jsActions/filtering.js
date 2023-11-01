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
        if(value !== "clear") searchParams.set(key, value);
        else searchParams.delete(key)
    } else if(value !== "clear") {
        searchParams.append(key, value);
    }

    var updatedURL = url.toString();

    window.location.href = updatedURL;
}

function fromProductToFiltering(key, value) {
    var currentURL = window.location.href;
    var url = new URL(currentURL);
    var searchParams = url.searchParams;

    searchParams.delete("productName");
    searchParams.append(key, value);

    var updatedURL = 'shoes.php?' + url.searchParams.toString();

    window.location.href = updatedURL;
}
