

function filterDocuments() {
    var input, filter, documentList, cards, h6, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toLowerCase();
    documentList = document.getElementById('documentList');
    cards = documentList.getElementsByClassName('document-item');
    var noDocumentsMessage = document.getElementById('noDocuments');

    var hasVisibleDocuments = false;

    for (i = 0; i < cards.length; i++) {
        h6 = cards[i].getElementsByTagName("h6")[0];
        if (h6) {
            txtValue = h6.textContent || h6.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
                hasVisibleDocuments = true;
            } else {
                cards[i].style.display = "none";
            }
        }
    }

    // Show or hide the "No documents found" message
    if (!hasVisibleDocuments) {
        noDocumentsMessage.style.display = "block";
    } else {
        noDocumentsMessage.style.display = "none";
    }
}
