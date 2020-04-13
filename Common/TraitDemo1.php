<?php
trait Fly {
    public $name = 'fly';

    public function attr() {
        echo 'this is fly attr';
    }
}

class Animal{
    public function eat() {
        echo 'animal can eat something';
    }
}

// php无法同时从两个基类中继承属性和方法，Trait这个特性解决了这个问题，如果是有同样的方法，trait覆盖基类，本类继承trait，当不同的trait中，却有着同名的方法或属性，会产生冲突，可以使用insteadof或 as进行解决，insteadof 是进行替代，而as是给它取别名
class Bird extends Animal {
    use Fly;

    public function bird_name() {
        echo 'this is a bird';
    }
}


$bird = new Bird();
$bird->eat();
$bird->attr();
$bird->bird_name();
