function openTab(evt, tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => content.classList.remove('show'));

    // Remove 'active' class from all tabs
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => tab.classList.remove('active'));

    // Show the current tab content and add 'active' class to the clicked tab
    document.getElementById(tabName).classList.add('show');
    evt.currentTarget.classList.add('active');
}