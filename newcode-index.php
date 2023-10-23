<?php include("header.php") ?>


<div id="Enter-Page">









    <div>




        <form id="newcode" method="post" action="php/newcode.php" autocomplete="off">
            <div class="left-form">


                <label for="newcode">کد فنی</label>
                <input onkeydown="upperCaseF(this)" type="text" name="newcode" id="newcode-in">

            </div>
            <div class="right-form">





                <label class="small-label" for="doll-gen">دلار جنیون</label>
                <input class="small-input" type="number" name="doll-gen" id="doll-gen">



                <label class="small-label" for="doll-psq">دلار پارت</label>
                <input class="small-input" type="number" name="doll-psq" id="doll-psq">

                <p style="Clear:both"></p>
                <label class="small-label" for="doll-mob">دلار موبیز</label>
                <input class="small-input" type="number" name="doll-mob" id="doll-mob">


                <label class="small-label" for="doll-pm">دلار پارس</label>
                <input class="small-input" type="number" name="doll-pm" id="doll-pm">

                <div class="bottom-bar">
                    <input type="submit" value="افزودن کد فنی" id="">
                    <div class="error">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<?php include("footer.php") ?>