import React, { useState } from "react";
import "./css/register.css";

function Register() {
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
    const [firstname, setFirstname] = useState("");
    const [lastname, setLastname] = useState("");
    const [email, setEmail] = useState("");

    const handleRegister = async (e) => {
        e.preventDefault();
        try {
            const response = await fetch("http://localhost:8000/api/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ username, password, firstname, lastname, email }),
            });

            const data = await response.json();
            if (response.ok) {
                alert("Inscription réussie !");
            } else {
                alert(data.message || "Une erreur s'est produite.");
            }
        } catch (error) {
            console.error("Erreur :", error);
            alert("Impossible de se connecter au serveur.");
        }
    };

    return (
        <div className="container">
            <h2 className="title">Inscription</h2>
            <form onSubmit={handleRegister} className="form">
                <div className="input-group">
                    <label className="label">Prénom :</label>
                    <input
                        type="text"
                        value={firstname}
                        onChange={(e) => setFirstname(e.target.value)}
                        className="input"
                        required
                    />
                </div>
                <div className="input-group">
                    <label className="label">Nom :</label>
                    <input
                        type="text"
                        value={lastname}
                        onChange={(e) => setLastname(e.target.value)}
                        className="input"
                        required
                    />
                </div>
                <div className="input-group">
                    <label className="label">Email :</label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        className="input"
                        required
                    />
                </div>
                <div className="input-group">
                    <label className="label">Nom d'utilisateur :</label>
                    <input
                        type="text"
                        value={username}
                        onChange={(e) => setUsername(e.target.value)}
                        className="input"
                        required
                    />
                </div>
                <div className="input-group">
                    <label className="label">Mot de passe :</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        className="input"
                        required
                    />
                </div>
                <button type="submit" className="button">S'inscrire</button>
                <p>Déjà inscrit ? <a href="/login">Connectez-vous</a></p>
            </form>
        </div>
    );
}

export default Register;
