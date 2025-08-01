"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Shop from "@/pages/Shop";

export default function ShopPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Shop />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 