
<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "pdo.php";


/* =========================
   GET STUDENTS
========================= */

$sql = "SELECT * FROM students ORDER BY id DESC";

$stmt = $conn->prepare($sql);

$stmt->execute();

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);


/* =========================
   STATISTICS
========================= */

$total = count($students);

$adults = 0;
$minors = 0;

foreach ($students as $s) {

    if ($s['age'] >= 18) {
        $adults++;
    } else {
        $minors++;
    }

}


/* =========================
   FLASH MESSAGE
========================= */

$flash = $_SESSION['flash'] ?? null;

unset($_SESSION['flash']);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Dashboard | StudentHub</title>


<style>

/* =========================
   RESET
========================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: #f3f6fb;
    color: #1f2937;
}

a {
    text-decoration: none;
}


/* =========================
   LAYOUT
========================= */

.layout {
    min-height: 100vh;
    display: flex;
}


/* =========================
   SIDEBAR
========================= */

.sidebar {
    width: 250px;
    background: #111827;
    color: white;

    position: fixed;

    left: 0;
    top: 0;
    bottom: 0;

    display: flex;
    flex-direction: column;
}


/* =========================
   BRAND
========================= */

.brand {
    height: 75px;

    display: flex;
    align-items: center;

    gap: 12px;

    padding: 0 22px;

    border-bottom: 1px solid #273244;
}

.brand .logo {
    width: 42px;
    height: 42px;

    border-radius: 10px;

    background: #2563eb;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 23px;
}

.brand span {
    font-size: 20px;
    font-weight: bold;
}


/* =========================
   NAVIGATION
========================= */

.sidebar nav {
    padding: 25px 14px;
}

.nav-title {
    font-size: 11px;

    color: #9ca3af;

    text-transform: uppercase;

    letter-spacing: 1px;

    margin: 0 12px 10px;
}

.sidebar nav a {
    display: flex;

    align-items: center;

    gap: 12px;

    color: #d1d5db;

    padding: 12px 14px;

    margin-bottom: 6px;

    border-radius: 8px;

    font-size: 14px;

    transition: 0.2s;
}

.sidebar nav a:hover {
    background: #1f2937;
    color: white;
}

.sidebar nav a.active {
    background: #2563eb;
    color: white;
}


/* =========================
   USER
========================= */

.sidebar-footer {
    margin-top: auto;

    padding: 18px;

    border-top: 1px solid #273244;
}

.user {
    display: flex;

    align-items: center;

    gap: 10px;
}

.user-avatar {
    width: 40px;
    height: 40px;

    border-radius: 50%;

    background: #2563eb;

    color: white;

    display: flex;

    align-items: center;
    justify-content: center;

    font-weight: bold;
}

.user-name {
    font-size: 14px;
    font-weight: bold;
}


/* =========================
   MAIN
========================= */

.main {
    margin-left: 250px;

    width: calc(100% - 250px);

    padding: 32px;
}


/* =========================
   TOPBAR
========================= */

.topbar {
    margin-bottom: 28px;
}

.topbar h1 {
    font-size: 30px;

    color: #111827;

    margin-bottom: 6px;
}

.topbar p {
    color: #6b7280;

    font-size: 14px;
}


/* =========================
   ALERT
========================= */

.alert {
    padding: 13px 16px;

    border-radius: 8px;

    margin-bottom: 20px;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
}


/* =========================
   STATISTICS
========================= */

.stats {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 20px;

    margin-bottom: 28px;
}

.stat-card {
    background: white;

    border-radius: 12px;

    padding: 22px;

    display: flex;

    align-items: center;

    gap: 16px;

    border: 1px solid #e5e7eb;

    box-shadow:
        0 3px 12px
        rgba(0,0,0,0.04);
}

.stat-icon {
    width: 55px;
    height: 55px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 25px;
}

.blue {
    background: #dbeafe;
}

.green {
    background: #dcfce7;
}

.orange {
    background: #ffedd5;
}

.stat-number {
    font-size: 28px;

    font-weight: bold;

    color: #111827;
}

.stat-title {
    font-size: 13px;

    color: #6b7280;

    margin-top: 4px;
}


/* =========================
   STUDENT CARD
========================= */

.card {
    background: white;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    padding: 24px;

    box-shadow:
        0 3px 12px
        rgba(0,0,0,0.04);
}

.card-header {
    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 20px;
}

.card-header h2 {
    font-size: 20px;

    color: #111827;
}


/* =========================
   ADD BUTTON
========================= */

.add-btn {
    background: #2563eb;

    color: white;

    padding: 10px 15px;

    border-radius: 8px;

    font-size: 14px;

    font-weight: bold;
}

.add-btn:hover {
    background: #1d4ed8;
}


/* =========================
   SEARCH
========================= */

.search {
    margin-bottom: 20px;
}

.search input {
    width: 100%;

    padding: 12px 15px;

    border: 1px solid #d1d5db;

    border-radius: 8px;

    font-size: 14px;

    outline: none;
}

.search input:focus {
    border-color: #2563eb;

    box-shadow:
        0 0 0 3px
        rgba(37,99,235,0.10);
}


/* =========================
   TABLE
========================= */

.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;

    border-collapse: collapse;
}

thead {
    background: #f9fafb;
}

th {
    text-align: left;

    padding: 14px;

    font-size: 12px;

    color: #6b7280;

    text-transform: uppercase;

    border-bottom:
        1px solid #e5e7eb;
}

td {
    padding: 14px;

    border-bottom:
        1px solid #f0f0f0;

    font-size: 14px;
}

tbody tr:hover {
    background: #f9fafb;
}


/* =========================
   STUDENT
========================= */

.student {
    display: flex;

    align-items: center;

    gap: 10px;
}

.student-avatar {
    width: 38px;
    height: 38px;

    border-radius: 50%;

    background: #dbeafe;

    color: #2563eb;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: bold;
}

.student-name {
    font-weight: bold;

    color: #111827;
}


/* =========================
   BADGES
========================= */

.badge {
    display: inline-block;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: bold;
}


/* Student Number */

.badge-number {
    min-width: 35px;

    text-align: center;

    background: #2563eb;

    color: white;
}


/* Adult */

.badge-adult {
    background: #dcfce7;

    color: #15803d;
}


/* Minor */

.badge-minor {
    background: #ffedd5;

    color: #c2410c;
}


/* =========================
   ACTIONS
========================= */

.actions {
    display: flex;

    gap: 7px;
}

.edit {
    background: #dbeafe;

    color: #2563eb;

    padding: 7px 11px;

    border-radius: 7px;

    font-size: 12px;

    font-weight: bold;
}

.edit:hover {
    background: #bfdbfe;
}

.delete {
    background: #fee2e2;

    color: #dc2626;

    padding: 7px 11px;

    border-radius: 7px;

    font-size: 12px;

    font-weight: bold;
}

.delete:hover {
    background: #fecaca;
}


/* =========================
   EMPTY
========================= */

.empty {
    text-align: center;

    padding: 50px;

    color: #6b7280;
}

.empty-icon {
    font-size: 45px;

    margin-bottom: 12px;
}

.empty a {
    display: inline-block;

    margin-top: 15px;

    background: #2563eb;

    color: white;

    padding: 10px 15px;

    border-radius: 8px;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 900px) {

    .stats {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 700px) {

    .sidebar {
        position: relative;

        width: 100%;

        min-height: auto;
    }

    .layout {
        display: block;
    }

    .sidebar-footer {
        display: none;
    }

    .main {
        margin-left: 0;

        width: 100%;

        padding: 20px;
    }

    .card-header {
        flex-direction: column;

        align-items: flex-start;

        gap: 15px;
    }

    .actions {
        flex-direction: column;
    }

}

</style>

</head>


<body>


<div class="layout">


<!-- =========================
     SIDEBAR
========================= -->

<aside class="sidebar">


    <div class="brand">

        <div class="logo">
            🎓
        </div>

        <span>
            StudentHub
        </span>

    </div>


    <nav>

        <div class="nav-title">
            Menu
        </div>


        <a href="dashboard.php"
           class="active">

            🏠
            Dashboard

        </a>


        <a href="create.php">

            ➕
            Add Student

        </a>


        <br>


        <div class="nav-title">
            Admin
        </div>


        <a href="logout.php">

            🚪
            Logout

        </a>

    </nav>


    <div class="sidebar-footer">

        <div class="user">


            <div class="user-avatar">

                <?php

                echo strtoupper(
                    substr(
                        $_SESSION['user_name'],
                        0,
                        1
                    )
                );

                ?>

            </div>


            <div class="user-name">

                <?php

                echo htmlspecialchars(
                    $_SESSION['user_name']
                );

                ?>

            </div>


        </div>

    </div>


</aside>



<!-- =========================
     MAIN
========================= -->

<main class="main">


    <div class="topbar">

        <h1>
            Dashboard
        </h1>

        <p>

            Welcome back,

            <strong>

                <?php

                echo htmlspecialchars(
                    $_SESSION['user_name']
                );

                ?>

            </strong>

        </p>

    </div>



    <!-- FLASH MESSAGE -->

    <?php if ($flash): ?>

        <div class="alert alert-<?php
            echo htmlspecialchars(
                $flash['type']
            );
        ?>">

            <?php

            echo htmlspecialchars(
                $flash['message']
            );

            ?>

        </div>

    <?php endif; ?>



    <!-- =========================
         STATISTICS
    ========================= -->

    <div class="stats">


        <div class="stat-card">

            <div class="stat-icon blue">
                👥
            </div>

            <div>

                <div class="stat-number">

                    <?php echo $total; ?>

                </div>

                <div class="stat-title">

                    Total Students

                </div>

            </div>

        </div>



        <div class="stat-card">

            <div class="stat-icon green">
                ✅
            </div>

            <div>

                <div class="stat-number">

                    <?php echo $adults; ?>

                </div>

                <div class="stat-title">

                    Adults (18+)

                </div>

            </div>

        </div>



        <div class="stat-card">

            <div class="stat-icon orange">
                🎓
            </div>

            <div>

                <div class="stat-number">

                    <?php echo $minors; ?>

                </div>

                <div class="stat-title">

                    Minors (&lt;18)

                </div>

            </div>

        </div>


    </div>



    <!-- =========================
         STUDENT RECORDS
    ========================= -->

    <div class="card">


        <div class="card-header">


            <h2>
                📋 Student Records
            </h2>


            <a href="create.php"
               class="add-btn">

                ➕ Add Student

            </a>


        </div>



        <!-- SEARCH -->

        <div class="search">

            <input
                type="text"
                id="searchInput"
                placeholder="🔍 Search by name or email..."
            >

        </div>



        <!-- TABLE -->

        <div class="table-wrapper">


            <table>


                <thead>

                    <tr>

                        <th>
                            Student No.
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Age
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody id="studentTable">


                <?php if (count($students) === 0): ?>


                    <tr>

                        <td colspan="6">


                            <div class="empty">


                                <div class="empty-icon">
                                    📋
                                </div>


                                <p>
                                    No students registered yet.
                                </p>


                                <a href="create.php">

                                    ➕ Add your first student

                                </a>


                            </div>


                        </td>

                    </tr>


                <?php else: ?>


                    <?php

                    /*
                     * $index starts from 0.
                     * We use $index + 1
                     * so Student No. starts from 1.
                     */

                    foreach (
                        $students
                        as $index => $stu
                    ):

                    ?>


                        <?php

                        $isAdult =
                            $stu['age'] >= 18;

                        $status =
                            $isAdult
                            ? "Adult"
                            : "Minor";

                        $badge =
                            $isAdult
                            ? "badge-adult"
                            : "badge-minor";

                        ?>


                        <tr data-row>


                            <!-- STUDENT NUMBER -->

                            <td>

                                <span
                                    class="badge badge-number"
                                >

                                    <?php

                                    echo $index + 1;

                                    ?>

                                </span>

                            </td>



                            <!-- NAME -->

                            <td>


                                <div class="student">


                                    <div
                                        class="student-avatar"
                                    >

                                        <?php

                                        echo strtoupper(
                                            substr(
                                                $stu['name'],
                                                0,
                                                1
                                            )
                                        );

                                        ?>

                                    </div>


                                    <div
                                        class="student-name"
                                    >

                                        <?php

                                        echo htmlspecialchars(
                                            $stu['name']
                                        );

                                        ?>

                                    </div>


                                </div>


                            </td>



                            <!-- EMAIL -->

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $stu['email']
                                );

                                ?>

                            </td>



                            <!-- AGE -->

                            <td>

                                <?php

                                echo $stu['age'];

                                ?>

                            </td>



                            <!-- STATUS -->

                            <td>


                                <span
                                    class="badge <?php
                                        echo $badge;
                                    ?>"
                                >

                                    <?php

                                    echo $status;

                                    ?>

                                </span>


                            </td>



                            <!-- ACTIONS -->

                            <td>


                                <div class="actions">


                                    <!-- IMPORTANT:
                                         Use database ID
                                         for Edit -->

                                    <a
                                        href="edit.php?id=<?php
                                            echo $stu['id'];
                                        ?>"
                                        class="edit"
                                    >

                                        ✏️ Edit

                                    </a>



                                    <!-- IMPORTANT:
                                         Use database ID
                                         for Delete -->

                                    <a
                                        href="delete.php?id=<?php
                                            echo $stu['id'];
                                        ?>"
                                        class="delete"

                                        onclick="return confirm(
                                            'Are you sure you want to delete this student?'
                                        );"
                                    >

                                        🗑️ Delete

                                    </a>


                                </div>


                            </td>


                        </tr>


                    <?php endforeach; ?>


                <?php endif; ?>


                </tbody>


            </table>


        </div>


    </div>


</main>


</div>



<!-- =========================
     SEARCH SCRIPT
========================= -->

<script>

const searchInput =
    document.getElementById(
        "searchInput"
    );


const rows =
    document.querySelectorAll(
        "#studentTable tr[data-row]"
    );


searchInput.addEventListener(
    "keyup",
    function () {

        const search =
            this.value.toLowerCase();


        rows.forEach(
            function(row) {

                const text =
                    row.textContent
                       .toLowerCase();


                if (
                    text.includes(search)
                ) {

                    row.style.display =
                        "";

                } else {

                    row.style.display =
                        "none";

                }

            }
        );

    }
);

</script>


</body>

</html>
