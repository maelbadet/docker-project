import React, {useState, useEffect} from "react";
import Loader from "./loader";
import './css/product-listing.css'

function Products() {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        fetch("http://localhost:8000/api/product")
            .then(response => response.json())
            .then(data => {
                setProducts(data.products);
            })
            .catch(error => console.error("Error fetching products:", error));
    }, []);

    if (products.length === 0) {
        return <Loader/>;
    }

    return (
        <div>
            <h2>Listing des produits</h2>
            {products.length === 0 ? (
                <p>Aucun produit disponible.</p>
            ) : (
                <div className="products-container">
                    {products.map(product => (
                        <a href={`/product/${product.id}`}>
                            <div className="product-card" key={product.id}>
                                <img
                                    src={`http://localhost:3000/img/${product.id}.png`}
                                    alt={product.name}
                                    className="product-image"
                                />
                                <div className="product-details">
                                    <h3 className="product-title">{product.name}</h3>
                                    <div className="product-info">
                                        <span className="product-format">{product.format} cl</span>
                                        <span className="product-price">{product.price}€</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    ))}
                </div>
            )}
        </div>
    );
}

export default Products;
