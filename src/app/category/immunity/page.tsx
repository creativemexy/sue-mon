"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import CategoryImmunity from "@/pages/CategoryImmunity";

export default function ImmunityCategoryPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <CategoryImmunity />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 