
"use client"

import { useEffect, useState } from "react";
import { supabase } from "@/integrations/supabase/client";
import ProductCard from "@/components/ProductCard";

interface Product {
  id: string;
  name: string;
  description: string;
  price: number;
  original_price?: number;
  image: string;
  rating: number;
  reviews: number;
  benefits: string[];
  category: string;
  in_stock: boolean;
  is_new: boolean;
  is_bestseller: boolean;
}

const CategoryEnergy = () => {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        if (!supabase) {
          console.log('Supabase client not available');
          setLoading(false);
          return;
        }

        const { data, error } = await supabase
          .from('products')
          .select('*')
          .eq('category', 'energy')
          .eq('in_stock', true)
          .order('created_at', { ascending: false });

        if (error) {
          console.log('Error fetching products:', error);
          setProducts([]);
        } else {
          setProducts(data || []);
        }
      } catch (error) {
        console.error('Error fetching products:', error);
        setProducts([]);
      } finally {
        setLoading(false);
      }
    };

    fetchProducts();
  }, []);

  if (loading) {
    return (
      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h1 className="text-3xl font-bold text-foreground mb-4">Energy Blends</h1>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Natural energy solutions to power through your day without the crash.
            </p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {[1, 2, 3, 4].map((i) => (
              <div key={i} className="animate-pulse">
                <div className="h-64 bg-muted rounded-lg mb-4"></div>
                <div className="h-4 bg-muted rounded w-3/4 mb-2"></div>
                <div className="h-3 bg-muted rounded w-1/2"></div>
              </div>
            ))}
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="py-8">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-12">
          <h1 className="text-3xl font-bold text-foreground mb-4">Energy Blends</h1>
          <p className="text-muted-foreground max-w-2xl mx-auto">
            Natural energy solutions to power through your day without the crash.
          </p>
        </div>
        
        {products.length === 0 ? (
          <div className="text-center py-12">
            <p className="text-muted-foreground">No products found in this category</p>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {products.map((product) => (
              <ProductCard 
                key={product.id} 
                product={{
                  id: product.id,
                  name: product.name,
                  description: product.description,
                  price: product.price,
                  originalPrice: product.original_price,
                  image: product.image,
                  rating: product.rating,
                  reviews: product.reviews,
                  benefits: product.benefits,
                  inStock: product.in_stock,
                  isNew: product.is_new,
                  isBestseller: product.is_bestseller
                }} 
              />
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

export default CategoryEnergy;