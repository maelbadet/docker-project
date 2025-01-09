import React, { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

function ProductPage() {
    const { id } = useParams();
    const [product, setProduct] = useState(null);

    useEffect(() => {
        fetch(`http://localhost:8080/api/product/${id}`)
            .then(response => response.json())
            .then(data => setProduct(data))
            .catch(error => console.error("Error fetching product:", error));
    }, [id]);

    if (!product) {
        return <p>Chargement...</p>;
    }

    return (
        <div>
            <h2>{product.name}</h2>
            <p>Prix : {product.price}€</p>
            <p>Description : {product.description}</p>
        </div>
    );
}

export default ProductPage;
