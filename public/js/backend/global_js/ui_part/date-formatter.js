function formatDate(dateString) {
    if (!dateString) return "";
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return dateString; // Safety: return raw value if date string parsing fails

    const options = {
        day: "2-digit",
        month: "long",
        year: "numeric",
    };
    return date.toLocaleDateString("en-GB", options);
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".format-date").forEach(function (el) {
        const original = el.textContent.trim();
        el.textContent = formatDate(original);
    });
});
