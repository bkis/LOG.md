
<div id="site-container">

    <!--
    Yes, this is allowed:
    https://www.w3.org/TR/html5/document-metadata.html#the-style-element
    -->
    <style>
        .rnd-col { transition: .2s; }
        .rnd-col-1:hover{ color: <?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)) ?>; }
        .rnd-col-2:hover{ color: <?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)) ?>; }
        .rnd-col-3:hover{ color: <?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)) ?>; }
    </style>

    <header>
        <div>
            <div id="header-title">
                <a href="?"><?php echo LOGMD_HEADER_TITLE ?></a>
                <span class="rnd-col rnd-col-1" title="WOW!">&olcir;</span>
                <span class="rnd-col rnd-col-2" title="UUhh!">&ofcir;</span>
                <span class="rnd-col rnd-col-3" title="Ooohh!">&cirscir;</span>
            </div>
            <div id="header-subtitle"><?php echo LOGMD_HEADER_SUBTITLE ?></div>
        </div>
    </header>

    <main>