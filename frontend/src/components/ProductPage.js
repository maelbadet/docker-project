import React, { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import Loader from "./loader";
import './css/product-page.css';

function ProductPage() {
    const { id } = useParams();
    const [product, setProduct] = useState(null);

    useEffect(() => {
        fetch(`http://localhost:8000/api/product/${id}`)
            .then(response => response.json())
            .then(data => setProduct(data))
            .catch(error => console.error("Error fetching product:", error));
    }, [id]);

    if (!product) {
        return <Loader />;
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
                </div>
            </div>
        </div>
    );
}

export default ProductPage;
