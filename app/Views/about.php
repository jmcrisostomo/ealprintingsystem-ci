
<?= view('customer/layout/header') ?>

<?= view('customer/layout/navbar') ?>

<style>
    :root {
    --color-white: #ffffff;
    --color-light: #f8fafc;
    --color-black: #121212;
    --color-night: #001632;
    --color-blue: #1a73e8;
    --color-gray: #80868b;
    --color-grayish: #dadce0;
    --shadow-normal: 0 1px 3px 0 rgba(0, 0, 0, 0.1),
      0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-medium: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
      0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-large: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
      0 4px 6px -2px rgba(0, 0, 0, 0.05);
  }
  
  :root {
    --white: hsla(0, 0%, 100%, 1);
    --white-transparent: hsla(0, 0%, 100%, 0.8);
    --white-transparent2: hsla(0, 0%, 100%, 0.1);
    --black: hsla(0, 0%, 0%, 0.8);
    --black-transparent: hsla(0, 0%, 0%, 0.5);
    --black-pure: hsla(0, 0%, 0%, 1);
    --blue-dark: hsla(223, 52.1%, 28.6%, 1);
    --blue-dark-light: hsla(223, 52.1%, 50%, 1);
    --blue-light: hsla(195, 93.6%, 50.8%, 1);
    --red: hsla(349, 100%, 43.9%, 1);
    --red-dark: hsla(349, 100%, 30%, 1);
    --red-transparent: hsla(349, 100%, 43.9%, 0.8);
    --yellow: hsla(44, 100%, 50%, 1);
    --yellow-dark: hsla(44, 100%, 40%, 1);
    --b-radius: 10px;
    --transition-speed: 0.2s;
    --danger: #D5202B;
    --success: #04aa6d;
  
  }

.form .input-control {
    position: relative;
    width: 100%;
    height: 3rem;
    margin-bottom: 1.25rem;
}

/* .form .white-input-label .input-label{
    background: transparent !important;
    color: white !important;
} */

/* .form .white-input-label .input-field{
    color: white !important;
} */

.form .input-label {
    position: absolute;
    font-family: inherit;
    font-size: 18px;
    /*font-size: 1rem;
    */font-weight: 400;
    line-height: inherit;
    left: 1rem;
    top: 0.75rem;
    padding: 0 0.25rem;
    color: var(--color-gray);
    background: var(--color-white);
    transition: all 0.3s ease;
    
}

.form .input-field {
    position: absolute;
    font-family: inherit;
    font-size: 1rem;
    font-weight: 400;
    line-height: inherit;
    top: 0;
    left: 0;
    width: 100%;
    height: auto;
    padding: 0.75rem 1.25rem;
    z-index: 1;
    border: 2px solid var(--color-grayish);
    outline: none;
    border-radius: 0.5rem;
    color: var(--color-black);
    background: transparent;
    transition: all 0.3s ease;
}

.form .input-field::-moz-placeholder {
    opacity: 0;
    visibility: hidden;
    color: transparent;
}

.form .input-field:-ms-input-placeholder {
    opacity: 0;
    visibility: hidden;
    color: transparent;
}

.form .input-field::placeholder {
    opacity: 0;
    visibility: hidden;
    color: transparent;
}

.form .input-field:focus {
    border: 2px solid var(--color-blue);
}

.form .input-field:focus+.input-label {
    font-size: 0.9rem;
    font-weight: 500;
    top: -0.75rem;
    left: 1rem;
    z-index: 5;
    color: var(--color-blue);
    border-radius: 15px;
    -webkit-border-radius: 15px;
    -moz-border-radius: 15px;
    -ms-border-radius: 15px;
    -o-border-radius: 15px;
}

.form .input-field:not(:-moz-placeholder-shown).input-field:not(:focus)+.input-label {
    font-size: 0.9rem;
    font-weight: 500;
    top: -0.75rem;
    left: 1rem;
    z-index: 5;
}

.form .input-field:not(:-ms-input-placeholder).input-field:not(:focus)+.input-label {
    font-size: 0.9rem;
    font-weight: 500;
    top: -0.75rem;
    left: 1rem;
    z-index: 5;
}

.form .input-field:not(:placeholder-shown).input-field:not(:focus)+.input-label {
    font-size: 0.9rem;
    font-weight: 500;
    top: -0.75rem;
    left: 1rem;
    z-index: 5;
}

.form .input-submit {
    font-family: inherit;
    font-size: 1rem;
    font-weight: 500;
    line-height: inherit;
    cursor: pointer;
    width: 100%;
    height: auto;
    padding: 0.75rem 1.25rem;
    margin-top: 1rem;
    border: none;
    outline: none;
    border-radius: 0.25rem;
    color: var(--color-white);
    background: var(--color-blue);
    box-shadow: var(--shadow-medium);
    text-transform: capitalize;
}
</style>


<!-- Start Featured Product -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">About Us</h1>
                <p>
                E.A.L Printing, also known as, Estipona Aguilar Local Printing, is a shop that does commercial printing. We print what you want to insert in your shirts, lanyards, mugs, and caps! 
                </p>
            </div>
        </div>
        <div class="row">
            <p>
            <span class="h3">Contact Us: </span>

            This is where you can contact/message us just by filling up the form down below and wait for our response. 
            </p>
            <div class="form" style="display:contents;">
                <div class="col-6">
                    <div class="input-control">
                        <input type="text" name="name" class="input-field" placeholder="Name" required>
                        <label for="name" class="input-label">Name</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-control">
                        <input type="text" name="email" class="input-field" placeholder="Email" required>
                        <label for="email" class="input-label">Email</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-control">
                        <input type="text" name="subject" class="input-field" placeholder="Subject" required>
                        <label for="subject" class="input-label">Subject</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-control mb-5">
                        <textarea style="resize:none" name="message" class="input-field" placeholder="Message"></textarea>
                        <label for="message" class="input-label">Message</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Featured Product -->

<?= view('customer/layout/footer') ?>