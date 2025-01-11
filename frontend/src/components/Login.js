import React, {useState, useContext} from "react";
import {useNavigate} from "react-router-dom";
import {UserContext} from "../UserContext";
import "./css/login.css";

function Login() {
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
    const navigate = useNavigate();
    const {setUser} = useContext(UserContext);

    const handleLogin = async (e) => {
        e.preventDefault();
        try {
            const response = await fetch("http://localhost:8000/api/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({username, password}),
            });

            const data = await response.json();
            if (response.ok) {
                const userId = data.userId;
                localStorage.setItem("userId", userId);
                setUser({id: userId});
                navigate("/");
            } else {
                alert(data.error || "Nom d'utilisateur ou mot de passe incorrect.");
            }
        } catch (error) {
            console.error("Erreur :", error);
            alert("Impossible de se connecter au serveur.");
        }
    };

    return (
        <div className="container">
            <h2 className="title">Connexion</h2>
            <form onSubmit={handleLogin} className="form">
                <div className="input-group">
                    <label className="label">Nom d'utilisateur :</label>
                    <input
                        type="text"
                        value={username}
                        onChange={(e) => setUsername(e.target.value)}
                        className="input"
                    />
                </div>
                <div className="input-group">
                    <label className="label">Mot de passe :</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        className="input"
                    />
                </div>
                <button type="submit" className="button">
                    Se connecter
                </button>
                <p>pas encore de compte ? <a href="/register">Inscrivez vous</a></p>
            </form>
        </div>
    );
}

export default Login;
