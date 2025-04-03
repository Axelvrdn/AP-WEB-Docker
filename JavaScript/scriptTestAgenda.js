document.addEventListener("DOMContentLoaded", function() {
    const allowedDates = [
        "2025-04-01",
        "2025-04-05",
        "2025-04-10"
    ]; // Liste des dates autorisées

    const allAprilDates = [];
    const startDate = new Date("2025-04-01");
    const endDate = new Date("2025-04-30");

    for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
        allAprilDates.push(new Date(d).toISOString().split("T")[0]);
    }

    const disabledDates = allAprilDates.filter(date => !allowedDates.includes(date));

    const picker = flatpickr("#date", {
        disable: disabledDates, 
        minDate: "2025-04-01",
        maxDate: "2025-04-30",
        dateFormat: "Y-m-d",
        disableMobile: true,
        theme: "light",
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const dateStr = dayElem.dateObj.toISOString().split("T")[0];
            if (allowedDates.includes(dateStr)) {
                dayElem.classList.add("allowed"); // Applique le style des dates autorisées
            }
        }
    });
});