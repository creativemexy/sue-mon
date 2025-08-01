"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import CategoryHeart from "@/pages/CategoryHeart";

export default function HeartCategoryPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <CategoryHeart />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 