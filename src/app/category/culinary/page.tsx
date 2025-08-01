"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import CategoryCulinary from "@/pages/CategoryCulinary";

export default function CulinaryCategoryPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <CategoryCulinary />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 