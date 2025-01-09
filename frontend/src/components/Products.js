import React, { useState, useEffect } from "react";

function Products() {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        fetch("http://localhost:8080/api/product")
            .then(response => response.json())
            .then(data => setProducts(data))
            .catch(error => console.error("Error fetching products:", error));
    }, []);

    return (
        <div>
            <h2>Listing des produits</h2>
            {products.length === 0 ? (
                <p>Aucun produit disponible.</p>
            ) : (
                <ul>
                    {products.map(product => (
                        <li key={product.id}>
                            <a href={`/product/${product.id}`}>
                                {product.name} - {product.price}€
                            </a>
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
}

export default Products;
