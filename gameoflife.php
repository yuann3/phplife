<?php
class GameOfLife {
    private $grid;
    private $rows;
    private $cols;

    public function __construct($rows, $cols) {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->grid = array();
        $this->initializeGrid();
    }

    private function initializeGrid() {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $this->grid[$i][$j] = rand(0, 1);
            }
        }
    }

    public function getGrid() {
        return $this->grid;
    }

    private function countNeighbors($row, $col) {
        $count = 0;
        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                if ($i == 0 && $j == 0) continue;
                $newRow = ($row + $i + $this->rows) % $this->rows;
                $newCol = ($col + $j + $this->cols) % $this->cols;
                $count += $this->grid[$newRow][$newCol];
            }
        }
        return $count;
    }

    public function nextGeneration() {
        $newGrind = array();

        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $neighbors = $this->countNeighbors($i, $j);
                $newGrid[$i][$j] = $this->grid[$i][$j];

                if ($this->grid[$i][$j] == 1) {
                    if ($neighbors < 2 || $neighbors > 3) {
                        $newGrid[$i][$j] = 0;
                    }
                } else {
                    if ($neighbors == 3) {
                        $newGrid[$i][$j] = 1;
                    }
                }
            }
        }
        $this->grid = $newGrid;
    }
}

session_start();
if (!isset($_SESSION['game']) || isset($_POST['reset'])) {
    $_SESSION['game'] = new GameOfLife(60, 60);
}

if (isset($_POST['next'])) {
    $_SESSION['game']->nextGeneration();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Game of Life in 20 mins</title>
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(30, 20px);
            gap: 1px;
            background-color: #ccc;
            padding: 10px;
            margin: 20px auto;
            width: fit-content;
        }
        .cell {
            width: 20px;
            height: 20px;
            background-color: white;
        }
        .alive {
            background-color: black;
        }
        .controls {
            text-align: center;
            margin: 20px;
        }
        button {
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
            cursor: pointer;
        }
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Game of Life in 20mins</h1>
    
    <div class="grid">
        <?php
        $grid = $_SESSION['game']->getGrid();
        for ($i = 0; $i < 30; $i++) {
            for ($j = 0; $j < 30; $j++) {
                echo '<div class="cell ' . ($grid[$i][$j] ? 'alive' : '') . '"></div>';
            }
        }
        ?>
    </div>

    <div class="controls">
        <form method="post">
            <button type="submit" name="next">Click me to fuck react</button>
            <button type="submit" name="reset">Click me to destory JS</button>
        </form>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <h3>Rules:</h3>
        <p>1. Any live cell with fewer than two live neighbors dies (underpopulation)</p>
        <p>2. Any live cell with two or three live neighbors lives on to the next generation</p>
        <p>3. Any live cell with more than three live neighbors dies (overpopulation)</p>
        <p>4. Any dead cell with exactly three live neighbors becomes a live cell (reproduction)</p>
    </div>
</body>
</html>
