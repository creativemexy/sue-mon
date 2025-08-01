"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import CategoryTraditional from "@/pages/CategoryTraditional";

export default function TraditionalCategoryPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <CategoryTraditional />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 