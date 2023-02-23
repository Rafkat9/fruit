<?php

interface ITree 
{
    public function newTree($a, $b); // Добавить дерево принимает Тип дерева по сути это название бд

    public function allFruit(); // Подсчитывать общее кол-во собранных плодов для каждого типа деревьев.

}

class Trees implements ITree
{
    // tree
    protected $treeType; // тип дерева яб или гр - pear or apple
    protected $treeNumber; // порядковый номер дерева id - не подойдет - для проверки на существование

    // fruit
    protected $frutPear; // общее кол
    protected $weightPear; // вес груш
    protected $frutApple; // общее кол
    protected $weightApple; // вес яблок

    // добавление дерева 1 парпаметр тип 2 уник номер
    public function newTree($a, $b)
    {

        $pdo = new PDO('mysql:host=localhost;dbname=trees', 'root', '');
        $sql = "INSERT INTO tree (tree_type, tree_unique_number) VALUES (:tree_type, :tree_unique_number)";
        $statement = $pdo->prepare($sql);
        $statement->execute(['tree_type' => $b, 'tree_unique_number' => $a]);
    }
    // все фрукты по типам и получение веса
    public function allFruit() 
    {
        $pdo = new PDO('mysql:host=localhost;dbname=trees', 'root', '');
        $sql = 'SELECT * FROM tree';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $treeAll = $statement->fetchAll(PDO::FETCH_DEFAULT);
        $frut = [];

        foreach($treeAll as $key => $elem) {
            foreach($elem as $keys=> $el) {

                if($el == 'pear'){
                    $r = rand(0,20);
                    $wP = rand(130,170);
                    $this->frutPear += $r;
                    $this->weightPear += $wP;
                }
                if($el == 'apple'){
                    $r = rand(40,50);
                    $wA = rand(150,180);
                    $this->frutApple += $r;
                    $this->weightApple += $wA;
                }
            }
        }
    }

    public function getAllApple()
    {
        return $this->frutApple;
    }
    public function weightApple()
    {
        $res = $this->weightApple / 100;
        return $res;
    }
    public function getAllPear()
    {
        return $this->frutPear;
    }
    public function weighPear()
    {
        $res = $this->weightPear / 100;
        return $res;
    }
    public function allFruits()
    {
        $res = $this->frutPear + $this->frutApple;
        return $res;
    }
     
}

///////////////////////////////
$tr = new Trees;
$tr->allFruit();
echo 'Всего яблок: '. $tr->getAllApple(). "</br>";
echo 'Всего груш: ' . $tr->getAllPear().  "</br>";
echo "</br>";
echo 'Вес яблок: '.  $tr->weightApple() . "</br>";
echo 'Вес груш: ' .  $tr->weightApple() . "</br>";
echo "</br>";

echo 'Общее количество: ' . $tr->allFruits();

// $tr->newTree('apple',40); // добавление дерева 1- тип 2- уник номер / проверку на уникальномть не сделал




