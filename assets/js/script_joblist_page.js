function applyFilters() {
    // Get filter values
    const searchInput = document.getElementById('searchInput').value;
    const companySkillTag = document.getElementById('companySkillTag').value;
    const permanent = document.getElementById('permanent').checked ? 'permanent' : '';
    const cos = document.getElementById('cos').checked ? 'cos' : '';

    // Create a query string
    const queryString = `searchInput=${searchInput}&companySkillTag=${companySkillTag}&permanent=${permanent}&cos=${cos}`;

    // Make an AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `./php_connections/fetch_jobs_joblist_page.php?${queryString}`, true);
    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById('job-list-container').innerHTML = this.responseText;
        }
    };
    xhr.send();
}
