const classOptions = {
    "Creche": ["Creche 1", "Creche 2"],
    "Nursery": ["Nursery 1", "Nursery 2"],
    "Primary": ["Primary 1","Primary 2","Primary 3","Primary 4","Primary 5","Primary 6"],
    "JHS": ["JHS 1","JHS 2","JHS 3"],
    "SHS": ["SHS 1","SHS 2","SHS 3"]
};

document.getElementById('level').addEventListener('change', function() {
    const classes = classOptions[this.value] || [];
    const classSelect = document.getElementById('class_name');
    classSelect.innerHTML = '<option value="">Select Class</option>';
    classes.forEach(cls => {
        const option = document.createElement('option');
        option.value = cls;
        option.textContent = cls;
        classSelect.appendChild(option);
    });
});
