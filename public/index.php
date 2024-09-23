<?php
session_start();
include_once '../config/database.php';

// Fetch election data and results
$database = new Database();
$conn = $database->getConnection();
$candidates_query = "SELECT id, name, description, image FROM candidates";
$candidates_stmt = $conn->prepare($candidates_query);
$candidates_stmt->execute();
$candidates = $candidates_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose ONE-Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<style>
body {
    background-color: #f4f4f4;
}
.index-container {
    margin-top: 50px;
    padding-top: 1px;
    border-radius: 10px;
    background-color: #ffff ;
    padding-bottom: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    padding-left: 25px;
}
.candidate-card {
    margin-bottom: 20px;
	border: 0px;
    background-color: rgba(240, 240, 240, 0.877);

}
.candidate-card img {
    max-height: 200px;
    object-fit: cover;
}
</style>

<body>
    <!-- Include Navbar -->
    <?php include 'components/navbar.php'; ?>

    <div class="container index-container">
        <h3 class="my-4">Candidate Information</h3>
        <div class="row">
            <?php foreach ($candidates as $candidate) : ?>
                <div class="col-md-4">
                    <div class="card candidate-card">
                        <?php if (!empty($candidate['image'])) : ?>
                            <img src="<?php echo htmlspecialchars($candidate['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($candidate['name']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($candidate['name']); ?></h5>
                            <!-- Details Button -->
                            <button class="btn btn-info" data-toggle="modal" data-target="#detailsModal<?php echo $candidate['id']; ?>">Details</button>
                            <!-- Vote Button -->
                            <form action="process_vote.php" method="POST" style="display: inline;">
                                <input type="hidden" name="candidate" value="<?php echo htmlspecialchars($candidate['name']); ?>">
                                <button type="submit" class="btn btn-primary">Vote</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Details Modal -->
                <div class="modal fade" id="detailsModal<?php echo $candidate['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel<?php echo $candidate['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsModalLabel<?php echo $candidate['id']; ?>"><?php echo htmlspecialchars($candidate['name']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php echo htmlspecialchars($candidate['description']); ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
<!-- Display Live Results -->
 <div class='liveresult'>
        <h3 class="my-4">Live Election Results:</h3>
        <?php
        $results_query = "SELECT candidate, COUNT(*) as votes FROM votes GROUP BY candidate";
        $results_stmt = $conn->prepare($results_query);
        $results_stmt->execute();
        $results = $results_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            echo "<p>" . htmlspecialchars($result['candidate']) . ": " . htmlspecialchars($result['votes']) . " votes</p>";
        }
        ?>
    </div>
    </div>


<?php include 'components/footer.php'; ?>


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
