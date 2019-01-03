
<style>
    #container {
        position: relative;
        height: 700px;
        width: 500px;
        margin: 10px auto;
        overflow: hidden;
        border: 4px solid #5C090A;
        background: #4E4226 url('/static/image/backgroundLeaves.jpg') no-repeat top left;
    }

    /* Defines the position and dimensions of the leafContainer div */
    #leafContainer
    {
        position: absolute;
        width: 100%;
        height: 100%;
    }

    /* Defines the appearance, position, and dimensions of the message div */
    #message
    {
        position: absolute;
        top: 160px;
        width: 100%;
        height: 300px;
        background:transparent url('/static/image/textBackground.png') repeat-x center;
        color: #5C090A;
        font-size: 150%;
        font-family: 'Georgia';
        text-align: center;
        padding: 20px 10px;
        -webkit-box-sizing: border-box;
        -webkit-background-size: 100% 100%;
        z-index: 1;
    }

    p {
        margin: 15px;
    }

    a
    {
        color: #5C090A;
        text-decoration: none;
    }

    /* Sets the color of the "Dino's Gardening Service" message */
    em
    {
        font-weight: bold;
        font-style: normal;
    }

    .phone {
        font-size: 150%;
        vertical-align: middle;
    }

    /* This CSS rule is applied to all div elements in the leafContainer div.
       It styles and animates each leafDiv.
    */
    #leafContainer > div
    {
        position: absolute;
        width: 100px;
        height: 100px;

        /* We use the following properties to apply the fade and drop animations to each leaf.
           Each of these properties takes two values. These values respectively match a setting
           for fade and drop.
        */
        -webkit-animation-iteration-count: infinite, infinite;
        -webkit-animation-direction: normal, normal;
        -webkit-animation-timing-function: linear, ease-in;
    }

    /* This CSS rule is applied to all img elements directly inside div elements which are
       directly inside the leafContainer div. In other words, it matches the 'img' elements
       inside the leafDivs which are created in the createALeaf() function.
    */
    #leafContainer > div > img {
        position: absolute;
        width: 100px;
        height: 100px;

        /* We use the following properties to adjust the clockwiseSpin or counterclockwiseSpinAndFlip
           animations on each leaf.
           The createALeaf function in the Leaves.js file determines whether a leaf has the
           clockwiseSpin or counterclockwiseSpinAndFlip animation.
        */
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-direction: alternate;
        -webkit-animation-timing-function: ease-in-out;
        -webkit-transform-origin: 50% -100%;
    }

    /* Hides a leaf towards the very end of the animation */
    @-webkit-keyframes fade
    {
        /* Show a leaf while into or below 95 percent of the animation and hide it, otherwise */
        0%   { opacity: 1; }
        95%  { opacity: 1; }
        100% { opacity: 0; }
    }

    /* Makes a leaf fall from -300 to 600 pixels in the y-axis */
    @-webkit-keyframes drop
    {
        /* Move a leaf to -300 pixels in the y-axis at the start of the animation */
        0%   { -webkit-transform: translate(0px, -50px); }
        /* Move a leaf to 600 pixels in the y-axis at the end of the animation */
        100% { -webkit-transform: translate(0px, 650px); }
    }

    /* Rotates a leaf from -50 to 50 degrees in 2D space */
    @-webkit-keyframes clockwiseSpin
    {
        /* Rotate a leaf by -50 degrees in 2D space at the start of the animation */
        0%   { -webkit-transform: rotate(-50deg); }
        /*  Rotate a leaf by 50 degrees in 2D space at the end of the animation */
        100% { -webkit-transform: rotate(50deg); }
    }

    /* Flips a leaf and rotates it from 50 to -50 degrees in 2D space */
    @-webkit-keyframes counterclockwiseSpinAndFlip
    {
        /* Flip a leaf and rotate it by 50 degrees in 2D space at the start of the animation */
        0%   { -webkit-transform: scale(-1, 1) rotate(50deg); }
        /* Flip a leaf and rotate it by -50 degrees in 2D space at the end of the animation */
        100% { -webkit-transform: scale(-1, 1) rotate(-50deg); }
    }

</style>
<main id="main" class="site-main" role="main">
    <div id="container">
        <!-- The container is dynamically populated using the init function in leaves.js -->
        <!-- Its dimensions and position are defined using its id selector in leaves.css -->
        <div id="leafContainer"></div>
        <!-- its appearance, dimensions, and position are defined using its id selector in leaves.css -->
        <div id="message">
            <?php
                foreach ($list as $val) {
                    echo "<div  style='text-align: left'><a href='/article/nav/".$val['id']."'><img style='width:32px;height:32px;' src='".$val['image']."' /> <span style='font-size: 24'>".$val['name']."篇</span></a></div></hr>";
                }
                ?>
        </div>
    </div>

</main>
<script>
    /* Define the number of leaves to be used in the animation */
    const NUMBER_OF_LEAVES = 30;

    /*
        Called when the "Falling Leaves" page is completely loaded.
    */
    function init()
    {
        /* Get a reference to the element that will contain the leaves */
        var container = document.getElementById('leafContainer');
        /* Fill the empty container with new leaves */
        for (var i = 0; i < NUMBER_OF_LEAVES; i++)
        {
            container.appendChild(createALeaf());
        }
    }

    /*
        Receives the lowest and highest values of a range and
        returns a random integer that falls within that range.
    */
    function randomInteger(low, high)
    {
        return low + Math.floor(Math.random() * (high - low));
    }

    /*
       Receives the lowest and highest values of a range and
       returns a random float that falls within that range.
    */
    function randomFloat(low, high)
    {
        return low + Math.random() * (high - low);
    }

    /*
        Receives a number and returns its CSS pixel value.
    */
    function pixelValue(value)
    {
        return value + 'px';
    }

    /*
        Returns a duration value for the falling animation.
    */

    function durationValue(value)
    {
        return value + 's';
    }

    /*
        Uses an img element to create each leaf. "Leaves.css" implements two spin
        animations for the leaves: clockwiseSpin and counterclockwiseSpinAndFlip. This
        function determines which of these spin animations should be applied to each leaf.

    */
    function createALeaf()
    {
        /* Start by creating a wrapper div, and an empty img element */
        var leafDiv = document.createElement('div');
        var image = document.createElement('img');

        /* Randomly choose a leaf image and assign it to the newly created element */
        image.src = '/static/image/realLeaf' + randomInteger(1, 5) + '.png';

        leafDiv.style.top = "-100px";

        /* Position the leaf at a random location along the screen */
        leafDiv.style.left = pixelValue(randomInteger(0, 500));

        /* Randomly choose a spin animation */
        var spinAnimationName = (Math.random() < 0.5) ? 'clockwiseSpin' : 'counterclockwiseSpinAndFlip';

        /* Set the -webkit-animation-name property with these values */
        leafDiv.style.webkitAnimationName = 'fade, drop';
        image.style.webkitAnimationName = spinAnimationName;

        /* Figure out a random duration for the fade and drop animations */
        var fadeAndDropDuration = durationValue(randomFloat(5, 11));

        /* Figure out another random duration for the spin animation */
        var spinDuration = durationValue(randomFloat(4, 8));
        /* Set the -webkit-animation-duration property with these values */
        leafDiv.style.webkitAnimationDuration = fadeAndDropDuration + ', ' + fadeAndDropDuration;

        var leafDelay = durationValue(randomFloat(0, 5));
        leafDiv.style.webkitAnimationDelay = leafDelay + ', ' + leafDelay;

        image.style.webkitAnimationDuration = spinDuration;

        // add the <img> to the <div>
        leafDiv.appendChild(image);

        /* Return this img element so it can be added to the document */
        return leafDiv;
    }

    /* Calls the init function when the "Falling Leaves" page is full loaded */
    window.addEventListener('load', init, false);


</script>