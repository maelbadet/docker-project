import React, {useState, useEffect, useContext} from "react";
import {UserContext} from "../UserContext";
import {useNavigate} from "react-router-dom";
import Loader from "./loader";
import "./css/favorites.css";

function Favorites() {
    const {user} = useContext(UserContext);
    const navigate = useNavigate();
    const [favorites, setFavorites] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if (!user) {
            navigate("/login");
            return;
        }

        const userId = localStorage.getItem("userId");
        if (!userId) {
            console.error("User ID is missing in localStorage");
            navigate("/login");
            return;
        }

        fetch(`http://localhost:8000/api/favorites/${userId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to fetch favorites");
                }
                return response.json();
            })
            .then(data => {
                console.log('Favorites Data:', data);
                if (Array.isArray(data)) {
                    setFavorites(data);
                } else {
                    console.error('Invalid data format', data);
                }
                setLoading(false);
            })
            .catch(error => {
                console.error("Error fetching favorites:", error);
                setLoading(false);
            });
    }, [user, navigate]);


    if (loading) {
        return <Loader/>;
    }

    if (favorites.length === 0) {
        return <p>No favorites found</p>;
    }

    return (
        <div className="favorites-container">
            <h2>Mes favoris</h2>
            <ul>
                {favorites.map(favorite => (
                    <li key={favorite.id}>
                        <div className="favorite-item">
                            <img src={`http://localhost:3000/img/${favorite.product_id}.png`}
                                 alt={favorite.product_name}/>
                            <h3>{favorite.product_name}</h3>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default Favorites;
