function setCKEditorValue(name, value) {
    if (window.patientEditors && window.patientEditors[name]) {
        window.patientEditors[name].setData(value || "");
        return true;
    }
    return false;
}
