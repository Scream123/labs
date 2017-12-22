
/*var num = 2;
var exp = 10;
var cnt = 1;
 var result = 1;
while (cnt<= exp){
    result *= num;
    cnt++;
}
console.log(result);
*/
/*    var num = 2;
    var exp = 10;
var result = 1;
    for(var cnt = 1;cnt<=exp;cnt++){
        result *= num;
        //console.log(i);
    }
console.log(result);
// Лабораторная работа 2.2
*/
   /* do {
        var answer =  prompt("Say 'stop'");

        console.log("You said'"+answer+"'.");
    }
    while(answer != "stop");
       */
///////////////////////////////////////
/* for(var i = 0; i<=10; i++){
if(i==0)
    console.log(i+"-zero");
else if(i == 0)
    console.log(i+"-even");
else
    console.log(i+"-odd");
}
*/
// Лабораторная работа 2.3
   /* var age = 120;
    if(age>=18 && age<60)
        console.log("Вам еще работать и работать");
    else if (age>=60)
        console.log("Вам пора на пенсию");
    else if (age<=17 && age>=1)
        console.log("Вам работать еще рано-учитесь");
      else
        console.log("не допустимое значение");
*/
////////////////////////////////////////////////////////////
 /*   var  num = 121;
    var str = "На ветке сидит "+num+" ворон";
    var x =  "";
    /*
        1->a
        2,3,4->ы
        11-14
        */
/*
if(num%100<11 || num%100>14){
    switch (num%10){
        case 1: x = "a"; break;
        case 2:
        case 3:
        case 4: x = "ы";
    }
}
   console.log(str+x);
*/

// Лабораторная работа 3.1
  /*  function power(base,exp){
        var cnt =1;
        var result = 1;
        while(cnt<exp) {
            result *= base;
            cnt++;
        }
        return result;
    }
    console.log(power(2,10));
console.log(power(5,10));
*/
// Лабораторная работа 3.2
/*    function compare(x){
        return function(y){
           var res = ( y>x ? true: ( y<x ? false: null));
            return res;
        };
    }

    var sum = compare(10);
    console.log( sum(5));
    console.log( sum(2));
    console.log( sum(10));
    console.log( sum(15));
*/
// Лабораторная работа 4.1
    /*var book1={};
    book1.title = "JS";
    book1.pubyear = 2016;
    book1.price = 200;
    var book2 = {
       "title" : "PHP",
       "pubyear" : 2016,
        "price" :300
    };
        for(var i in book1&&book2)
        console.log(i+":"+book1[i]+"|"+i+book2[i]);
*/
// Лабораторная работа 4.2
  /*  var book1={};
        book1.title = "JS";
        book1.pubyear = 2016;
        book1.price = 200;
        book1.show = function(){
            return (this.title+"-"+this.price);

        };


        function showBook(){
            return(this.title+"-"+this.price);


        }
    var book2 = {
        "title" : "PHP",
        "pubyear" : 2016,
        "price" :300,
       show:showBook
};
   console.log(book1.show());
    console.log(book2.show());
    */
// Лабораторная работа 4.3
/* var a = [5,12];
    var b = [];
    a[99]=7;
for (var i in a){
    b.push(Math.pow(a[i],2));
}
console.log(b);
*/
////или//////////////
/*var a = [5,12];
v/*r b = [];
a[99]=7;
        for(var i =0;i<a.length;i++) {
            if (typeof (a == "object")){
                b.push(Math.pow(a[i], 2));
        }else
               "it's not int";
        }
        console.log(b);
*/
// Лабораторная работа 5.1
/*    var s = "Мы знаем, что монохромный цвет - это  градации серого";
    var txt = 'хром';
    var word;
     var pos = s.indexOf(txt);
    if(pos != -1) {
        //ищем пробел слева направо от txt
    var start = s.lastIndexOf(" ", pos) + 5;
         var end = s.indexOf(" ", pos)-3;
        if(end == -1) {
            word = s.slice(start);
        }else
         word = s.slice(start, end);
    }
console.log(word);
*/

// или так
 /*    var txt = 'хром';
    var str = s.slice(18,22)
    var word = str;
    console.log(word);
*/
// Лабораторная работа 5.2
//даты:
    //25-02-2012
//варианты:
// ^-ограничение с начала строки
// $-ограничение с конца строки
//console.log(/^\d\d?-\d\d?-\d{4}$/.test("25-02-2012"));
    // /\d{1,2}-\d{1,2}-\d{4}/
    // /[0-3]?\d-[0-2]?\d-[1-2]?\d/{3}
//25-2-2012
//    console.log(/^\d\d{0,1}-\d+-\d{4}$/.test("25-2-2012"));
//01-12-2011
//console.log(/^\d\d?-\d\d?-\d{4}$/.test("01-12-2011"));
//2-12-1978
//console.log(/^\d+-\d\d?-\d{4}$/.test("25-02-2012"));
/////////////////////////////////////////////////////
// /*var s = "Smith, John\nDow, Mike\nLee, Steve";
/*var b = s.replace(/([a-z]+), ([a-z]+)/ig, "$2 $1");
console.log(b);
*/
// Лабораторная работа 6.1
 /*   function Book(){
        this.title= null;
        this.pubYear=null;
        this.price=null;
    }
    var book = new Book();
        book.title = "PHP",
        book.pubYear = 2016,
        book.price = 300,

    Book.prototype.show =function(){
        return (this.title +"-" +this.price)
    }
    console.log(book.show());
*/
// Лабораторная работа 6.2
    function getDate(str){
        //проверяем правильная ли дата
        var f = str.match(/(^\d\d{0,1})-(\d+)-(\d{4}$)/);
        if(f)
        return new Date(f[3],f[2]-1,f[1]);
    }
    var d = getDate("25-2-2012");
    console.log(d.toString());














