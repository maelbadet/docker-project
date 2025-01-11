import React, {useState, useEffect, useContext} from "react";
import {UserContext} from "../UserContext";
import {useNavigate} from "react-router-dom";
import "./css/account.css";

function Account() {
    const {user, setUser} = useContext(UserContext);
    const [userInfo, setUserInfo] = useState(null);
    const [activeSection, setActiveSection] = useState("account");
    const [editMode, setEditMode] = useState(false);
    const [formData, setFormData] = useState({
        username: "",
        firstName: "",
        lastName: "",
        email: "",
    });
    const navigate = useNavigate();

    useEffect(() => {
        if (!user) {
            navigate("/login");
        } else {
            fetch(`http://localhost:8000/api/getInfo/${user.id}`)
                .then((response) => response.json())
                .then((data) => {
                    setUserInfo(data);
                    setFormData({
                        username: data.username,
                        firstName: data.firstName,
                        lastName: data.lastName,
                        email: data.email,
                    });
                })
                .catch((error) => console.error("Erreur lors du chargement des données utilisateur:", error));
        }
    }, [user, navigate]);

    const handleLogout = () => {
        localStorage.removeItem("userId");
        setUser(null);
        navigate("/");
    };

    const handleChange = (e) => {
        const {name, value} = e.target;
        setFormData({...formData, [name]: value});
    };

    const handleSave = (e) => {
        e.preventDefault();
        fetch("http://localhost:8000/api/updateInfo", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(formData),
        })
            .then((response) => response.json())
            .then((data) => {
                setUserInfo(data);
                setEditMode(false);
            })
            .catch((error) => console.error("Erreur lors de la mise à jour des informations :", error));
    };

    const renderSection = () => {
        if (!userInfo) {
            return <p>Chargement des informations utilisateur...</p>;
        }

        switch (activeSection) {
            case "account":
                return (
                    <div className="section">
                        <h2>Informations personnelles</h2>
                        {editMode ? (
                            <form onSubmit={handleSave}>
                                <div className="input-group">
                                    <label>Nom d'utilisateur :</label>
                                    <input
                                        type="text"
                                        name="username"
                                        value={formData.username}
                                        onChange={handleChange}
                                        required
                                    />
                                </div>
                                <div className="input-group">
                                    <label>Prénom :</label>
                                    <input
                                        type="text"
                                        name="firstName"
                                        value={formData.firstName}
                                        onChange={handleChange}
                                        required
                                    />
                                </div>
                                <div className="input-group">
                                    <label>Nom :</label>
                                    <input
                                        type="text"
                                        name="lastName"
                                        value={formData.lastName}
                                        onChange={handleChange}
                                        required
                                    />
                                </div>
                                <div className="input-group">
                                    <label>Email :</label>
                                    <input
                                        type="email"
                                        name="email"
                                        value={formData.email}
                                        onChange={handleChange}
                                        required
                                    />
                                </div>
                                <button type="submit">Sauvegarder</button>
                                <button type="button" onClick={() => setEditMode(false)}>
                                    Annuler
                                </button>
                            </form>
                        ) : (
                            <ul>
                                <li><strong>Nom d'utilisateur :</strong> {userInfo.username}</li>
                                <li><strong>Prénom :</strong> {userInfo.firstName}</li>
                                <li><strong>Nom :</strong> {userInfo.lastName}</li>
                                <li><strong>Email :</strong> {userInfo.email}</li>
                                <button onClick={() => setEditMode(true)}>Modifier</button>
                            </ul>
                        )}
                    </div>
                );
            case "updatepass":
                return (
                    <div className="section">
                        <h2>Modifier le mot de passe</h2>
                        <form>
                            <div className="input-group">
                                <label>Ancien mot de passe :</label>
                                <input type="password" required/>
                            </div>
                            <div className="input-group">
                                <label>Nouveau mot de passe :</label>
                                <input type="password" required/>
                            </div>
                            <div className="input-group">
                                <label>Confirmer le nouveau mot de passe :</label>
                                <input type="password" required/>
                            </div>
                            <button type="submit">Mettre à jour</button>
                        </form>
                    </div>
                );
            case "orders":
                return (
                    <div className="section">
                        <h2>Mes commandes</h2>
                        <p>Cette section affichera vos commandes.</p>
                    </div>
                );
            default:
                return null;
        }
    };

    return (
        <div className="account-container">
            <nav className="sidebar">
                <ul>
                    <li onClick={() => setActiveSection("account")}>Informations personnelles</li>
                    <li onClick={() => setActiveSection("updatepass")}>Modifier le mot de passe</li>
                    <li onClick={() => setActiveSection("orders")}>Mes commandes</li>
                    <li onClick={handleLogout}>Déconnexion</li>
                </ul>
            </nav>
            <div className="content">{renderSection()}</div>
        </div>
    );
}

export default Account;
