const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(attendedStudentsPerDay), // Days of the week
                datasets: [
                    {
                        label: 'Siswa Hadir',
                        data: Object.values(attendedStudentsPerDay), // Attendance data for students
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Guru Hadir',
                        data: Object.values(attendedTeachersPerDay), // Attendance data for teachers
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true,
                        min: 0,
                        ticks: {
                            stepSize: 10
                        }
                    }
                }
            }
        });