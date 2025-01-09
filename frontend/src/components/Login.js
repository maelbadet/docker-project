import React, { useState, useContext } from "react";
import { useNavigate } from "react-router-dom";
import { UserContext } from "../UserContext"; // Import du contexte

function Login() {
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
    const navigate = useNavigate();
    const { setUser } = useContext(UserContext); // Accéder à la fonction setUser du contexte

    const handleLogin = async (e) => {
        e.preventDefault();
        try {
            const response = await fetch("http://localhost:8080/api/login.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ username, password }),
            });

            const data = await response.json();
            if (response.ok) {
                const userId = data.id_user;
                localStorage.setItem("userId", userId);
                setUser({ id: userId });
                navigate("/");
            }
            else {
                alert(data.error || "Nom d'utilisateur ou mot de passe incorrect.");
            }
        } catch (error) {
            console.error("Erreur :", error);
            alert("Impossible de se connecter au serveur.");
        }
    };

    return (
        <div>
            <h2>Connexion</h2>
            <form onSubmit={handleLogin}>
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
                <button type="submit">Se connecter</button>
            </form>
        </div>
    );
}

export default Login;
