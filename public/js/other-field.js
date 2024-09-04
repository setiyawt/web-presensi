function toggleCourseInput() {
    var courseSelect = document.getElementById("course");
    var manualCourseGroup = document.getElementById("manual-course-group");
    if (courseSelect.value === "other") {
        manualCourseGroup.style.display = "flex";
    } else {
        manualCourseGroup.style.display = "none";
    }
}

function toggleClassroomInput() {
    var classroomSelect = document.getElementById("classroom");
    var manualClassroomGroup = document.getElementById("manual-classroom-group");
    if (classroomSelect.value === "other") {
        manualClassroomGroup.style.display = "flex";
    } else {
        manualClassroomGroup.style.display = "none";
    }
}