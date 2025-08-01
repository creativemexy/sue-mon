"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import CategoryEnergy from "@/pages/CategoryEnergy";

export default function EnergyCategoryPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <CategoryEnergy />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 