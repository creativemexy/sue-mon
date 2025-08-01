"use client"

import Navbar from "@/components/Navbar";
import Hero from "@/components/Hero";
import FeaturedProducts from "@/components/FeaturedProducts";
import Categories from "@/components/Categories";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";

export default function HomePage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Hero />
        <FeaturedProducts />
        <Categories />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 