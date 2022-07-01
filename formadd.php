			<link rel="stylesheet" href="styles.css" />
        <div class="formularz">
        
		<form  action="dodaj.php" method="post">
		
		<div class="bg" aria-hidden="true">
				<div class="bg__dot"></div>
				<div class="bg__dot"></div>
			</div>
			
			<div class="form__icon" aria-hidden="true"></div>
				<div class="form__input-container">
				<input type="hidden" name="wyslane" value="TRUE" />
     			
				
    			<input
						aria-label="User"
						class="form__input"
						type="text"
						id="login"
						name="login"
						placeholder=" "
					/>
					<label class="form__input-label" for="login">Login</label>
    			</div>
				<div class="form__input-container">
					<input
						aria-label="Password"
						class="form__input"
						type="password"
						id="haslo"
						name="haslo"
						placeholder=" "
					/>
					<label class="form__input-label" for="haslo">Hasło</label>
				</div>
    			<div class="form__input-container">
					<input
						aria-label="Password"
						class="form__input"
						type="password"
						id="haslo2"
						name="haslo2"
						placeholder=" "
					/>
					<label class="form__input-label" for="haslo">Powtórz Hasło</label>
				</div>
    			<div class="form__input-container">
					<input
						aria-label="Password"
						class="form__input"
						type="email"
						id="email"
						name="email"
						placeholder=" "
					/>
					<label class="form__input-label" for="haslo">Email</label>
				</div>
    			
    				    			
      	   <div class="form__spacer1" aria-hidden="true"></div>
				<button class="form__button">Zarejestruj mnie</button>
			
                 </form>