// Gestion du modal d'édition des sports favoris
function openEditSportModal(sportId, sportName) {
    document.getElementById('editSportId').value = sportId;
    document.getElementById('editSportModal').showModal();
}

function closeEditSportModal() {
    document.getElementById('editSportModal').close();
}

// Gestion du modal d'édition des informations d'un sport
function openEditSportInfoModal(sportId, sportName) {
    document.getElementById('editSportInfoId').value = sportId;
    document.getElementById('editSportInfoName').value = sportName;
    document.getElementById('editSportInfoModal').showModal();
}

function closeEditSportInfoModal() {
    document.getElementById('editSportInfoModal').close();
}

