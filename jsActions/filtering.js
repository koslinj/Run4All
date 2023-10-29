function toggleContent(element) {
    const content = element.parentElement.querySelector('.content');
    const arrow = element.querySelector('.toggle');

    if (content.style.display === "flex" || content.style.display === "") {
        content.style.display = "none";
        arrow.classList.add("closed");
        console.log("W ifie")
    } else {
        console.log("W elsie")
        content.style.display = "flex";
        arrow.classList.remove("closed");
    }
}

function addQueryParam(key, value) {
    var currentURL = window.location.href;
    var url = new URL(currentURL);
    var searchParams = url.searchParams;

    if (searchParams.has(key)) {
        searchParams.set(key, value);
    } else {
        searchParams.append(key, value);
    }

    var updatedURL = url.toString();

    window.location.href = updatedURL;
}
