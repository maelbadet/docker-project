import React, { useState } from "react";

function Register() {
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");

    const handleRegister = async (e) => {
        e.preventDefault();
        try {
            const response = await fetch("http://localhost:8080/api/register.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ username, password }),
            });

            const data = await response.json();
            if (response.ok) {
                alert("Inscription réussie !");
            } else {
                alert(data.error || "Une erreur s'est produite.");
            }
        } catch (error) {
            console.error("Erreur :", error);
            alert("Impossible de se connecter au serveur.");
        }
    };

    return (
        <div>
            <h2>Inscription</h2>
            <form onSubmit={handleRegister}>
                <label>
                    Nom d'utilisateur :
                    <input
                        type="text"
                        value={username}
                        onChange={(e) => setUsername(e.target.value)}
                    />
                </label>
                <br />
                <label>
                    Mot de passe :
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                    />
                </label>
                <br />
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    );
}

export default Register;
