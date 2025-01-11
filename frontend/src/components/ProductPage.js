import React, {useState, useEffect} from "react";
import {useParams} from "react-router-dom";
import Loader from "./loader";
import './css/product-page.css';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faHeart} from "@fortawesome/free-solid-svg-icons";

function ProductPage() {
    const {id} = useParams();
    const [product, setProduct] = useState(null);
    const [isFavorite, setIsFavorite] = useState(false);
    const userId = localStorage.getItem("userId");

    useEffect(() => {
        fetch(`http://localhost:8000/api/product/${id}`)
            .then(response => response.json())
            .then(data => setProduct(data))
            .catch(error => console.error("Error fetching product:", error));

        fetch(`http://localhost:8000/api/checkFavorite`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({user_id: userId, product_id: id}),
        })
            .then(response => {
                return response.json();
            })
            .then(data => setIsFavorite(data.isFavorite))
            .catch(error => console.error("Error checking favorite status:", error));
    }, [id]);

    const toggleFavorite = () => {
        const url = isFavorite
            ? `http://localhost:8000/api/removeFavorite`
            : `http://localhost:8000/api/addFavorite`;

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({user_id: userId, product_id: id}),
        })
            .then(response => response.json())
            .then(() => setIsFavorite(!isFavorite))
            .catch(error => console.error("Error updating favorite status:", error));
    };

    if (!product) {
        return <Loader/>;
    }

    return (
        <div className="product-page">
            <div className="product-container">
                <div className="product-image">
                    <img
                        src={`http://localhost:3000/img/${product.id}.png`}
                        alt={product.name}
                        className="image"
                    />
                </div>

                <div className="product-details">
                    <h2 className="product-name">{product.name}</h2>
                    <p className="product-price">{product.price}€</p>
                    <p className="product-description">{product.description}</p>
                    <p className="product-format">Format: {product.format} cl</p>
                    <p className="product-ean">EAN: {product.ean}</p>
                    <p className="product-quantity">Quantité disponible: {product.quantity}</p>

                    <button className="add-to-cart-btn">Ajouter au panier</button>

                    <button
                        className={`favorite-btn ${isFavorite ? "is-favorite" : ""}`}
                        onClick={toggleFavorite}
                    >
                        <FontAwesomeIcon icon={faHeart}/>
                        {isFavorite ? " Retirer des favoris" : " Ajouter aux favoris"}
                    </button>
                </div>
            </div>
        </div>
    );
}

export default ProductPage;
