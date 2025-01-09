import React, { useContext } from "react";
import { UserContext } from "../UserContext";
import { useNavigate } from "react-router-dom";

function Home() {
    const { user, setUser } = useContext(UserContext);
    const navigate = useNavigate();

    const handleLogout = () => {
        localStorage.removeItem("userId");
        setUser(null);
        navigate("/login");
    };

    return (
        <div>
            <h2>Bienvenue chez l'Egregor</h2>
            <p>la moutarde fallot, la moutarde qu'il vous faut !</p>
        </div>
    );
}

export default Home;
